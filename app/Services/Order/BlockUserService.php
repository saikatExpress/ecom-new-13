<?php

namespace App\Services\Order;

use App\Exceptions\CustomException;
use App\Models\Order\Order;
use App\Models\Order\OrderGuardBlock;
use App\Models\Order\OrderGuardLog;
use Illuminate\Support\Facades\DB;

class BlockUserService
{
    public function __construct(protected OrderGuardBlock $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size');
        $query = $this->model::query();

        if ($request->filled('phone_number')) {

            $normalizedPhone = $this->normalizePhone(
                $request->phone_number
            );

            $phoneHash = hash('sha256', $normalizedPhone);

            $query->where('type', 'phone')->where('value', $phoneHash);
        }

        $blockUsers =  $query
        ->when($request->filled('type'), function ($query) use ($request) {
            $query->where('type', $request->type);
        })
        ->when($request->filled('source'), function ($query) use ($request) {
            $query->where('source', $request->source);
        })
        ->when($request->filled('block_type'), function ($query) use ($request) {
            $query->where('block_type', $request->block_type);
        })
        ->when($request->has('is_active'), function ($query) use ($request) {
            $query->where('is_active', $request->boolean('is_active'));
        })
        ->latest()
        ->paginate($paginateSize);

        return $blockUsers;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (preg_match('/^01[3-9]\d{8}$/', $phone)) {
            return '88' . $phone;
        }

        if (preg_match('/^8801[3-9]\d{8}$/', $phone)) {
            return $phone;
        }

        throw new CustomException('Invalid Bangladesh mobile number.');
    }

    public function permanentlyBlockPhoneByOrder(int $orderId)
    {
        return DB::transaction(function () use ($orderId) {

            $order = Order::with('guardDetails')->findOrFail($orderId);

            $details = $order->guardDetails;

            if (!$details || !$details->phone_hash) {
                throw new CustomException(
                    'Order customer information not found.Some ip missing'
                );
            }

            $phoneHash = $details->phone_hash;

            $existingBlock = OrderGuardBlock::where('type', 'phone')
                ->where('value', $phoneHash)
                ->first();

            $alreadyBlocked = $existingBlock && $existingBlock->is_active && $existingBlock->block_type === 'permanent';

            $block = OrderGuardBlock::updateOrCreate(
                [
                    'type' => 'phone',
                    'value' => $phoneHash,
                ],
                [
                    'phone_number' => $order->phone_number,
                    'reason'       => 'fake_order',
                    'block_type'   => 'permanent',
                    'source'       => 'admin',
                    'expires_at'   => null,
                    'is_active'    => true,
                ]
            );

            if (!$alreadyBlocked) {
                OrderGuardLog::create([
                    'order_id'        => $order->id,
                    'phone_hash'      => $phoneHash,
                    'user_token'      => $details->user_token,
                    'ip_address'      => $details->ip_address,
                    'action'          => 'blocked',
                    'reason'          => 'manual_fake_order',
                    'violation_count' => 0,
                ]);
            }

            return $block;
        });
    }
}
