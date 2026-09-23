<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Order\CustomerType;

class CustomerTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'        => 'New',
                'slug'        => 'new',
                'order_range' => 0,
            ],
            [
                'name'        => 'Regular',
                'slug'        => 'regular',
                'order_range' => 2,
            ],
            [
                'name'        => 'VIP',
                'slug'        => 'vip',
                'order_range' => 4,
            ],
        ];

        foreach ($types as $type) {
            CustomerType::updateOrCreate(
                ['slug' => $type['slug']],
                [
                    'name'        => $type['name'],
                    'order_range' => $type['order_range'],
                    'status'      => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
