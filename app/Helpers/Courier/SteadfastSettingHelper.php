<?php

namespace App\Helpers\Courier;

class SteadfastSettingHelper
{
    public static function update($request): array
    {
        return [
            'STEAD_FAST_ENDPOINT'   => $request->base_url,
            'STEAD_FAST_API_KEY'    => $request->api_key,
            'STEAD_FAST_SECRET_KEY' => $request->secret_key,
        ];
    }
}
