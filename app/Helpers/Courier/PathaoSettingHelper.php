<?php

namespace App\Helpers\Courier;

class PathaoSettingHelper
{
    public static function update($request): array
    {
        return [
            'PATHAO_ENDPOINT'      => $request->base_url,
            'PATHAO_CLIENT_ID'     => $request->client_id,
            'PATHAO_CLIENT_SECRET' => $request->client_secret,
            'PATHAO_USERNAME'      => $request->username,
            'PATHAO_PASSWORD'      => $request->password,
            'PATHAO_GRANT_TYPE'    => $request->grant_type,
        ];
    }
}
