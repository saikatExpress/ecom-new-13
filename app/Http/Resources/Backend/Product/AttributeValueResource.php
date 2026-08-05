<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'attribute_value' => $this->value,

            'attribute' => $this->whenLoaded('attribute', function () {
                return [
                    'id'   => $this->attribute->id,
                    'name' => $this->attribute->name,
                    'slug' => $this->attribute->slug,
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
