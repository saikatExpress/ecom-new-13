<?php

namespace App\Http\Resources\Frontend\Product;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'slug'     => $this->slug,
            'image'    => FileUrlHelper::url($this->img_path),
            'products'   => $this->products_count,
        ];
    }
}
