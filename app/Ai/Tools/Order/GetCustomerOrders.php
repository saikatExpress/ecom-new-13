<?php

namespace App\Ai\Tools\Order;

use Stringable;
use App\Models\Order\Order;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class GetCustomerOrders implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get recent orders belonging to a customer using their phone number.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'phone' => ['required','string','max:30'],
        ]);

        $orders = Order::query()
            ->where('phone',$validated['phone'])
            ->latest('id')
            ->limit(20)
            ->get([
                'id',
                'order_number',
                'status',
                'total',
                'created_at',
            ]);

        return json_encode(
            [
                'phone' => $validated['phone'],
                'count' => $orders->count(),
                'orders' => $orders->toArray(),
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'phone' => $schema->string()->required(),
        ];
    }
}
