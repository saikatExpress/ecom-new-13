<?php

namespace App\Ai\Tools\Customer;

use Stringable;
use App\Models\Order\Order;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class GetCustomer implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get customer information using phone number. A customer is identified by the phone number used in orders.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate(['phone_number' => ['required','string','max:30']]);

        $phoneNumber = $validated['phone_number'];

        $orders = Order::query()
            ->where('phone_number',$phoneNumber)
            ->latest('id')
            ->limit(20)
            ->get([
                'id',
                'order_number',
                'phone_number',
                'status',
                'total',
                'created_at',
            ]);

        if ($orders->isEmpty()) {
            return json_encode(
                [
                    'found' => false,
                    'message' => 'No customer/order found for this phone number.',
                ],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        $firstOrder = $orders->first();

        $totalOrders = Order::query()->where('phone_number',$phoneNumber)->count();

        $totalSpent = Order::query()->where('phone_number',$phoneNumber)->sum('total');

        $lastOrder = Order::query()->where('phone_number',$phoneNumber)
            ->latest('id')
            ->first([
                'id',
                'order_number',
                'status',
                'total',
                'created_at',
            ]);

        return json_encode(
            [
                'found' => true,
                'customer' => [
                    'phone_number'  => $phoneNumber,
                    'name'          => $firstOrder->name ?? null,
                    'total_orders'  => $totalOrders,
                    'total_spent'   => $totalSpent,
                    'last_order'    => $lastOrder?->toArray(),
                    'recent_orders' => $orders->toArray(),
                ],
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'phone_number' => $schema->string()->required(),
        ];
    }
}
