<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Order\DeliveryGateway;

class DeliveryGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name'        => 'Inside Dhaka',
                'min_time'    => 1,
                'max_time'    => 2,
                'time_unit'   => 'days',
                'delivery_fee'=> 80,
                'position'    => 1,
            ],
            [
                'name'        => 'Outside Dhaka',
                'min_time'    => 2,
                'max_time'    => 5,
                'time_unit'   => 'days',
                'delivery_fee'=> 130,
                'position'    => 2,
            ],
        ];

        foreach ($gateways as $gateway) {
            DeliveryGateway::updateOrCreate(
                [
                    'slug' => Str::slug($gateway['name']),
                ],
                [
                    'name'         => $gateway['name'],
                    'min_time'     => $gateway['min_time'],
                    'max_time'     => $gateway['max_time'],
                    'time_unit'    => $gateway['time_unit'],
                    'delivery_fee' => $gateway['delivery_fee'],
                    'position'     => $gateway['position'],
                    'status'       => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
