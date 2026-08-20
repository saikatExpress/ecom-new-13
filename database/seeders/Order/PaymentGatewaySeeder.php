<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Order\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name'           => 'Cash On Delivery',
                'account_number' => null,
                'position'       => 1,
            ],
            [
                'name'           => 'bKash',
                'account_number' => '01710000021',
                'position'       => 2,
            ],
            [
                'name'           => 'Nagad',
                'account_number' => '01710000022',
                'position'       => 3,
            ],
            [
                'name'           => 'Rocket',
                'account_number' => '01710000023',
                'position'       => 4,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                [
                    'slug' => Str::slug($gateway['name']),
                ],
                [
                    'name'           => $gateway['name'],
                    'account_number' => $gateway['account_number'],
                    'img_path'       => null,
                    'position'       => $gateway['position'],
                    'status'         => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
