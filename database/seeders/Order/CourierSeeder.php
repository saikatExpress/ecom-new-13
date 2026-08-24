<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\Order\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $couriers = [
            [
                'name'        => 'Pathao',
                'is_default'  => true,
            ],
            [
                'name'        => 'SteadFast',
                'is_default'  => false,
            ],
            [
                'name'        => 'RedX',
                'is_default'  => false,
            ],
            [
                'name'        => 'Paperfly',
                'is_default'  => false,
            ],
        ];

        foreach ($couriers as $courier) {

            Courier::updateOrCreate(
                [
                    'slug' => Str::slug($courier['name']),
                ],
                [
                    'name'       => $courier['name'],
                    'is_default' => $courier['is_default'],
                    'status'     => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
