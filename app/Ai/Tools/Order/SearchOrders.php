<?php

namespace App\Ai\Tools\Order;

use Stringable;
use App\Models\Order\Order;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class SearchOrders implements Tool
{
    public function description(): Stringable|string
    {
        return 'Search ecommerce orders using order number, customer phone number, order status, or keyword.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'order_number' => ['nullable','string','max:100'],
            'phone'        => ['nullable','string','max:30'],
            'status'       => ['nullable','string','max:50'],
            'keyword'      => ['nullable','string','max:255'],
        ]);

        $orders = Order::query()
            ->when($validated['order_number'] ?? null, fn ($query, $orderNumber) => $query->where('order_number', $orderNumber))
            ->when($validated['phone'] ?? null,fn ($query, $phone) => $query->where('phone', $phone))
            ->when($validated['status'] ?? null,fn ($query, $status) => $query->where('status', $status))
            ->when($validated['keyword'] ?? null,
                function ($query, $keyword) {
                    $query->where(function ($query) use ($keyword) {
                        $query->where('order_number','like',"%{$keyword}%")->orWhere('phone','like',"%{$keyword}%");
                    });
                }
            )
            ->latest('id')
            ->limit(20)
            ->get([
                'id',
                'order_number',
                'phone',
                'status',
                'total',
                'created_at',
            ]);

        return json_encode(
            [
                'count' => $orders->count(),
                'orders' => $orders->toArray(),
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'order_number' => $schema->string()->nullable(),
            'phone'        => $schema->string()->nullable(),
            'status'       => $schema->string()->nullable(),
            'keyword'      => $schema->string()->nullable(),
        ];
    }
}
