<?php

namespace App\Http\Resources\Backend\Order;

use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'order_id'            => $this->order_id,
            'product_id'          => $this->product_id,
            'product_name'        => $this->product_name,
            'product_sku'         => $this->product_sku,
            'product_img_path'    => FileUrlHelper::url($this->product_img_path),
            'product_variant_id'  => $this->product_variant_id,
            'variant_name'        => $this->variant_name,
            'variant_sku'         => $this->variant_sku,
            'variant_options'     => $this->variant_options,
            'quantity'            => $this->quantity,
            'buy_price'           => $this->buy_price,
            'mrp'                 => $this->mrp,
            'discount'            => $this->discount,
            'sell_price'          => $this->sell_price,
            'profit'              => $this->profit,

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

            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
            'deleted_at'          => $this->deleted_at,
        ];
    }
}
