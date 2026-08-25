<?php

namespace App\Services\Order;

use Illuminate\Support\Facades\DB;
use App\Models\Order\OrderGuardSetting;

class OrderGuardSettingService
{
    public function __construct(protected OrderGuardSetting $model){}

    public function show()
    {
        $setting = $this->model::where('status', 'active')->first();

        return $setting;
    }

    public function update($request)
    {
        return DB::transaction(function () use ($request) {
            $setting = $this->model->where('status', 'active')->firstOrFail();

            $setting->update([
                'phone_order_limit'             => $request->phone_order_limit,
                'phone_order_period_value'      => $request->phone_order_period_value,
                'phone_order_period_unit'       => $request->phone_order_period_unit,
                'ip_order_limit'                => $request->ip_order_limit,
                'ip_order_period_value'         => $request->ip_order_period_value,
                'ip_order_period_unit'          => $request->ip_order_period_unit,
                'user_token_order_limit'        => $request->user_token_order_limit,
                'user_token_order_period_value' => $request->user_token_order_period_value,
                'user_token_order_period_unit'  => $request->user_token_order_period_unit,
                'auto_block_enabled'            => $request->auto_block_enabled,
                'block_after_attempts'          => $request->block_after_attempts,
                'block_duration_value'          => $request->block_duration_value,
                'block_duration_unit'           => $request->block_duration_unit,
                'block_message'                 => $request->block_message,
            ]);

            return $setting;
        });
    }
}
