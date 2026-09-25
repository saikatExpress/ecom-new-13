<?php

namespace App\Helpers\Order;

use App\Models\Setting;
use App\Exceptions\CustomException;

class InvoiceHelper
{
    public static function generate(): string
    {
        $prefixSetting = Setting::query()->where('setting_key', 'invoice_prefix')->lockForUpdate()->first();

        if (!$prefixSetting) {
            throw new CustomException('Invoice prefix setting not found.');
        }

        $prefix = trim($prefixSetting->value);

        if ($prefix === '') {
            throw new CustomException('Invoice prefix cannot be empty.');
        }

        $sequenceSetting = Setting::query()->where('setting_key', 'invoice_sequence')->lockForUpdate()->first();

        if (!$sequenceSetting) {
            throw new CustomException('Invoice sequence setting not found.');
        }

        $sequence = (int) $sequenceSetting->value + 1;

        $sequenceSetting->value = $sequence;
        $sequenceSetting->save();

        return $prefix . str_pad($sequence,4,'0',STR_PAD_LEFT);
    }
}
