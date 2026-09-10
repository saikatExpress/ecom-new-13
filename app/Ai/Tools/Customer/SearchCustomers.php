<?php

namespace App\Ai\Tools\Customer;

use Stringable;
use App\Models\Order\Order;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class SearchCustomers implements Tool
{
    public function description(): Stringable|string
    {
        return 'Search customers using their phone number. Customers are identified by unique phone numbers from orders.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'phone_number' => ['nullable','string','max:30'],
        ]);

        $customers = Order::query()
            ->when($validated['phone_number'] ?? null, fn ($query, $phoneNumber) => $query->where('phone_number',$phoneNumber))
            ->select([
                'phone_number',
            ])
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('MAX(created_at) as last_order_at')
            ->groupBy('phone_number')
            ->latest('last_order_at')
            ->limit(20)
            ->get();

        return json_encode(
            [
                'count' => $customers->count(),
                'customers' => $customers->toArray(),
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'phone_number' => $schema->string()->nullable(),
        ];
    }
}
