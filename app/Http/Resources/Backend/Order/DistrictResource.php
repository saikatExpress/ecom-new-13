<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'division_name' => $this->division_name,
            'district_name' => $this->district_name,
            'orders_count'  => $this->orders_count,
            'status'        => $this->status,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
