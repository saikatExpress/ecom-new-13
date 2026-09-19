<?php

namespace App\Http\Resources\Backend\AI;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AiProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'image'      => FileUrlHelper::url($this->img_path),
            'is_default' => $this->is_default,
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
