<?php

namespace App\Helpers\Setting;

use App\Models\Setting;

class SettingHelper
{
    public static function setting(string $key, $default = null)
    {
        $setting = Setting::where('setting_key', $key)->first();

        return $setting?->value ?? $default;
    }
}
