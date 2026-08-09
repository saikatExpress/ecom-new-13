<?php

namespace App\Http\Resources\Backend\Product;

use App\Helpers\File\FileUrlHelper;
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
            'free_shipping'       => $this->free_shipping,
            'image'               => FileUrlHelper::url($this->img_path),
            'buy_price'           => $this->buy_price,
            'mrp'                 => $this->mrp,
            'sell_price'          => $this->sell_price,
            'offer_price'         => $this->offer_price,
            'offer_percentage'    => $this->offer_percentage,
            'discount_amount'     => $this->discount_amount,
            'current_stock'       => $this->current_stock,
            'total_sell_quantity' => $this->total_sell_quantity,
            'short_description'   => $this->short_description,
            'description'         => $this->description,
            'video_url'           => $this->video_url,
            'status'              => $this->status,
            'category'            => [
                'id'   => $this->whenLoaded('category', fn() => $this->category->id),
                'name' => $this->whenLoaded('category', fn() => $this->category->name),
            ],
            'subCategory'            => [
                'id'   => $this->whenLoaded('subCategory', fn() => $this->subCategory->id),
                'name' => $this->whenLoaded('subCategory', fn() => $this->subCategory->name),
            ],
            'brand' => [
                'id'   => $this->whenLoaded('brand', fn() => $this->brand?->id),
                'name' => $this->whenLoaded('brand', fn() => $this->brand?->name),
            ],
            'gallery_images' => GalleryResource::collection($this->whenLoaded('galleries')),
            'variants'       => ProductVariantResource::collection($this->whenLoaded('variants')),
            'created_at'     => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
