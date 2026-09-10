<?php

namespace App\Ai\Tools\Order;

use Stringable;
use App\Models\Order\Order;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class GetOrder implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get complete details of a specific ecommerce order using its order number.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'order_number' => ['required','string','max:100'],
        ]);

        $order = Order::query()
            ->with([
                'items',
            ])
            ->where('order_number',$validated['order_number'])
            ->first();

        if (! $order) {
            return json_encode(
                [
                    'found' => false,
                    'message' => 'Order not found.',
                ],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        return json_encode(
            [
                'found' => true,
                'order' => $order->toArray(),
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'order_number' => $schema->string()->required(),
        ];
    }
}
