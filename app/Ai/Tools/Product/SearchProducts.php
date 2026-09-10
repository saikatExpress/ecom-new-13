<?php

namespace App\Ai\Tools\Product;

use Stringable;
use Laravel\Ai\Tools\Request;
use Laravel\Ai\Contracts\Tool;
use App\Models\Product\Product;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class SearchProducts implements Tool
{
    public function description(): Stringable|string
    {
        return 'Search ecommerce products by name, SKU, minimum price, maximum price, or stock availability.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'query'     => ['nullable','string','max:255'],
            'sku'       => ['nullable','string','max:100'],
            'min_price' => ['nullable','numeric','min:0'],
            'max_price' => ['nullable','numeric','min:0'],
            'in_stock'  => ['nullable','boolean'],
        ]);

        $products = Product::query()
            ->when(
                $validated['query'] ?? null,
                function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name','like',"%{$search}%")->orWhere('sku','like',"%{$search}%");
                    });
                }
            )
            ->when($validated['sku'] ?? null, fn ($query, $sku) => $query->where('sku', $sku))
            ->when($validated['min_price'] ?? null,fn ($query, $price) => $query->where('sell_price','>=',$price))
            ->when($validated['max_price'] ?? null, fn ($query, $price) => $query->where('sell_price','<=',$price))
            ->when(array_key_exists('in_stock', $validated) && $validated['in_stock'] !== null,
                function ($query) use ($validated) {
                    if ($validated['in_stock']) {
                        $query->where('current_stock','>',0);
                    } else {
                        $query->where('current_stock','<=',0);
                    }
                }
            )
            ->latest('id')
            ->limit(20)
            ->get([
                'id',
                'name',
                'sku',
                'sell_price',
                'current_stock',
            ]);

        return json_encode(
            [
                'count' => $products->count(),
                'products' => $products->toArray(),
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query'     => $schema->string()->nullable(),
            'sku'       => $schema->string()->nullable(),
            'min_price' => $schema->number()->nullable(),
            'max_price' => $schema->number()->nullable(),
            'in_stock'  => $schema->boolean()->nullable(),
        ];
    }
}
