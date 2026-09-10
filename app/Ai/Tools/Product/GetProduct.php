<?php

namespace App\Ai\Tools\Product;

use Stringable;
use App\Models\Product\Product;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class GetProduct implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get detailed information about a specific product including its variations, using product ID or SKU.';
    }

    public function handle(Request $request): Stringable|string
    {
        $validated = $request->validate([
            'product_id' => ['nullable','integer','min:1',],
            'sku'        => ['nullable','string','max:100'],
        ]);

        $product = Product::query()
            ->with([
                'variants',
                'category',
                'subCategory',
                'brand',
            ])
            ->when($validated['product_id'] ?? null,fn ($query, $id) => $query->where('id', $id))
            ->when($validated['sku'] ?? null,fn ($query, $sku) => $query->where('sku', $sku))
            ->first([
                'id',
                'name',
                'sku',
                'buy_price',
                'mrp',
                'sell_price',
                'offer_price',
                'discount_amount',
                'offer_percentage',
                'current_stock',
                'total_sell_quantity',
                'status',
                'category_id',
                'sub_category_id',
                'brand_id',
            ]);

        if (! $product) {
            return json_encode(
                [
                    'found' => false,
                    'message' => 'Product not found.',
                ],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        return json_encode(
            [
                'found' => true,
                'product' => [
                    'id'   => $product->id,
                    'name' => $product->name,
                    'sku'  => $product->sku,

                    'price' => [
                        'buy_price'        => $product->buy_price,
                        'mrp'              => $product->mrp,
                        'sell_price'       => $product->sell_price,
                        'offer_price'      => $product->offer_price,
                        'discount_amount'  => $product->discount_amount,
                        'offer_percentage' => $product->offer_percentage,
                    ],

                    'stock' => [
                        'current_stock'       => $product->current_stock,
                        'total_sell_quantity' => $product->total_sell_quantity,
                    ],

                    'category'     => $product->category?->name,
                    'sub_category' => $product->subCategory?->name,
                    'brand'        => $product->brand?->name,
                    'status'       => $product->status,
                    'variants'     => $product->variants->toArray(),
                ],
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'product_id' => $schema->integer()->nullable(),
            'sku'        => $schema->string()->nullable(),
        ];
    }
}
