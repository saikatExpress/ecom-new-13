<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'image'      => FileUrlHelper::url($this->img_path),
            'status'     => $this->status,

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

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
