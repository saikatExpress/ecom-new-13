<?php

namespace App\Http\Resources\Backend\CMS;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'link'        => $this->link,
            'image'       => FileUrlHelper::url($this->img_path),
            'device_type' => $this->device_type,
            'status'      => $this->status,
            'section'     => $this->whenLoaded('section', function(){
                return [
                    'id'   => $this->section->id,
                    'name' => $this->section->name,
                ];
            }),
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
