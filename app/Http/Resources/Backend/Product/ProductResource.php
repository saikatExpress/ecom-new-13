<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'slug'                => $this->slug,
            'sku'                 => $this->sku,

            // Pricing Details
            'buy_price'           => $this->buy_price,
            'mrp'                 => $this->mrp,
            'sell_price'          => $this->sell_price,
            'offer_price'         => $this->offer_price,
            'discount_type'       => $this->discount_type,
            'discount_amount'     => $this->discount_amount,

            // Inventory
            'current_stock'       => $this->current_stock,
            'total_sell_quantity' => $this->total_sell_quantity,

            // Status
            'status'              => $this->status,

            // Relations (Uses whenLoaded to prevent N+1 queries if not loaded)
            'category' => [
                'id'   => $this->whenLoaded('category', fn() => $this->category->id),
                'name' => $this->whenLoaded('category', fn() => $this->category->name),
            ],
            'brand' => [
                'id'   => $this->whenLoaded('brand', fn() => $this->brand?->id),
                'name' => $this->whenLoaded('brand', fn() => $this->brand?->name),
            ],

            // Timestamps
            'created_at'          => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
