<?php

namespace App\Helpers\Courier;

class PaperflySettingHelper
{
    public static function update($request): array
    {
        return [
            'PAPERFLY_ENDPOINT' => $request->base_url,
            'PAPERFLY_USERNAME' => $request->username,
            'PAPERFLY_PASSWORD' => $request->password,
        ];
    }
}
