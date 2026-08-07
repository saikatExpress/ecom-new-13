<?php

namespace App\Http\Resources\Backend\Product;

use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => FileUrlHelper::url($this->img_path),
        ];
    }
}
