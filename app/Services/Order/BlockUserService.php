<?php

namespace App\Services\Order;

use App\Exceptions\CustomException;
use App\Models\Order\OrderGuardBlock;

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
}
