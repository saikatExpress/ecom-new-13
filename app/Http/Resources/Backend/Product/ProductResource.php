<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
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
            'variation_price_range' => $this->when(
                $this->relationLoaded('variants') && $this->variants->isNotEmpty(),
                function () {
                    return [
                        'min_price' => $this->variants->min('sell_price'),
                        'max_price' => $this->variants->max('sell_price'),
                    ];
                }
            ),
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
            'created_by' => $this->whenLoaded('createdBy', function(){
                return [
                    'id'       => $this->createdBy->id,
                    'username' => $this->createdBy->username,
                ];
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function(){
                return [
                    'id'       => $this->updatedBy->id,
                    'username' => $this->updatedBy->username,
                ];
            }),
            'deleted_by' => $this->whenLoaded('deletedBy', function(){
                return [
                    'id'       => $this->deletedBy->id,
                    'username' => $this->deletedBy->username,
                ];
            }),
            'gallery_images' => GalleryResource::collection($this->whenLoaded('galleries')),
            'variants'       => ProductVariantResource::collection($this->whenLoaded('variants')),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'deleted_at'     => $this->deleted_at,
        ];
    }
}
