<?php

namespace App\Http\Resources\Frontend\Order;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
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
            'mrp'                 => $this->mrp,
            'discount'            => $this->discount,
            'sell_price'          => $this->sell_price,
        ];
    }
}
