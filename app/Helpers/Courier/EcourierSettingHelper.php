<?php

namespace App\Helpers\Courier;

class EcourierSettingHelper
{
    public static function update($request): array
    {
        return [
            'ECOURIER_ENDPOINT'   => $request->base_url,
            'ECOURIER_API_KEY'    => $request->api_key,
            'ECOURIER_API_SECRET' => $request->api_secret,
        ];
    }
}
