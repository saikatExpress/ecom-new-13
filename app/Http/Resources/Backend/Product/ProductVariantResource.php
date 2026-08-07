<?php

namespace App\Http\Resources\Backend\Product;

use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'sku'               => $this->sku,
            'buy_price'         => $this->buy_price,
            'mrp'               => $this->mrp,
            'sell_price'        => $this->sell_price,
            'offer_price'       => $this->offer_price,
            'discount_type'     => $this->discount_type,
            'discount_amount'   => $this->discount_amount,
            'current_stock'     => $this->current_stock,
            'image'             => FileUrlHelper::url($this->img_path),
            'short_description' => $this->short_description,
            'description'       => $this->description,
            'is_default'        => $this->is_default,
            'status'            => $this->status,

            // Attribute Values mapping (e.g., Color: Red, Size: Large)
            'attribute_values' => $this->whenLoaded('attributeValues', function () {
                return $this->attributeValues->map(function ($attrValue) {
                    return [
                        'id'             => $attrValue->id,
                        'attribute_id'   => $attrValue->attribute_id,
                        'attribute_name' => $attrValue->attribute->name ?? null,
                        'value'          => $attrValue->value,
                    ];
                });
            }),
        ];
    }
}
