<?php

namespace App\Http\Resources\Frontend\CMS;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'link'        => $this->link,
            'device_type' => $this->device_type,
            'image'       => FileUrlHelper::url($this->img_path),
        ];
    }
}
