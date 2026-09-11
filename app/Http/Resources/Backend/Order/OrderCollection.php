<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        $orders = $this->resource['orders'];

        return [
            'items' => OrderResource::collection(
                $orders->getCollection()
            ),

            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
                'per_page'     => $orders->perPage(),
                'total'        => $orders->total(),
                'from'         => $orders->firstItem(),
                'to'           => $orders->lastItem(),
                'has_more'     => $orders->hasMorePages(),
            ],

            'statuses' => $this->resource['statuses'],
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
        ];
    }
}
