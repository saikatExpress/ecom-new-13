<?php

namespace App\Http\Resources\Frontend\CMS;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Frontend\Product\ProductResource;

class SectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'link'       => $this->link,
            'is_slider'  => $this->is_slider,
            'image'      => FileUrlHelper::url($this->img_path),
            'position'   => $this->position,
            'products'   => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
