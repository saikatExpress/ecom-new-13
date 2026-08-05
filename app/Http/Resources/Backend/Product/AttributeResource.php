<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,

            'attributeValues' => AttributeValueResource::collection(
                $this->whenLoaded('attributeValues')
            ),

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

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
