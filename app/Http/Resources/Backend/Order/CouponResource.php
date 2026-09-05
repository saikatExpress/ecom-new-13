<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'code'                => $this->code,
            'discount_type'       => $this->discount_type,
            'discount_value'      => $this->discount_value,
            'apply_scope'         => $this->apply_scope,
            'min_order_amount'    => $this->min_order_amount,
            'max_discount_amount' => $this->max_discount_amount,
            'usage_limit'         => $this->usage_limit,
            'per_phone_limit'     => $this->per_phone_limit,
            'used_count'          => $this->used_count,
            'starts_at'           => $this->starts_at,
            'expires_at'          => $this->expires_at,
            'status'              => $this->status,
            'products'            => $this->whenLoaded('products', function () {
                return $this->products->map(function ($product) {
                    return [
                        'id'   => $product->id,
                        'name' => $product->name,
                    ];
                });
            }),

            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id'   => $category->id,
                        'name' => $category->name,
                    ];
                });
            }),

            'created_by' => $this->whenLoaded('createdBy', function () {
                return [
                    'id'       => $this->createdBy->id,
                    'username' => $this->createdBy->username,
                ];
            }),

            'updated_by' => $this->whenLoaded('updatedBy', function () {
                return [
                    'id'       => $this->updatedBy->id,
                    'username' => $this->updatedBy->username,
                ];
            }),

            'deleted_by' => $this->whenLoaded('deletedBy', function () {
                return [
                    'id'       => $this->deletedBy->id,
                    'username' => $this->deletedBy->username,
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
