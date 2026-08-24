<?php

namespace App\Helpers\Courier;

class RedxSettingHelper
{
    public static function update($request): array
    {
        return [
            'REDX_ENDPOINT' => $request->base_url,
            'REDX_TOKEN'    => $request->token,
        ];
    }
}
