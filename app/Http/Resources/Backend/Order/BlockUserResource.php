<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'type' => $this->type,

            'value' => $this->type === 'phone' ? $this->phone_number : $this->value,

            'reason' => $this->reason,

            'block_type' => $this->block_type,

            'source' => $this->source,

            'expires_at' => $this->expires_at,

            'is_active' => $this->is_active,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
