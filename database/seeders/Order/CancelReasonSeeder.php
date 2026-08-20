<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Order\CancelReason;

class CancelReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            'Customer changed mind',
            'Ordered by mistake',
            'Found a better price',
            'Product no longer needed',
            'Wrong product selected',
            'Wrong quantity selected',
            'Delivery taking too long',
            'Payment issue',
            'Customer requested cancellation',
            'Duplicate order',
            'Product out of stock',
            'Unable to contact customer',
        ];

        foreach ($reasons as $reason) {
            CancelReason::updateOrCreate(
                [
                    'slug' => Str::slug($reason),
                ],
                [
                    'name'   => $reason,
                    'status' => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
