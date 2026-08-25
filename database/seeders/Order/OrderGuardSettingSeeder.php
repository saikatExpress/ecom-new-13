<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Order\OrderGuardSetting;

class OrderGuardSettingSeeder extends Seeder
{
    public function run(): void
    {
        OrderGuardSetting::updateOrCreate(
            ['id' => 1],
            [
                'phone_order_limit'        => 2,
                'phone_order_period_value' => 1,
                'phone_order_period_unit'  => 'day',

                'ip_order_limit'        => 5,
                'ip_order_period_value' => 1,
                'ip_order_period_unit'  => 'hour',

                'user_token_order_limit'        => 4,
                'user_token_order_period_value' => 1,
                'user_token_order_period_unit'  => 'hour',

                'auto_block_enabled'   => true,
                'block_after_attempts' => 3,

                'block_duration_value' => 1,
                'block_duration_unit'  => 'day',

                'block_message' => 'Too many order attempts. Please try again later.',

                'status' => StatusEnum::ACTIVE,
            ]
        );
    }
}
