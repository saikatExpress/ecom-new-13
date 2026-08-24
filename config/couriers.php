<?php

return [

    'pathao' => [
        'name'          => 'Pathao',
        'base_url'      => env('PATHAO_ENDPOINT'),
        'client_id'     => env('PATHAO_CLIENT_ID'),
        'client_secret' => env('PATHAO_CLIENT_SECRET'),
        'username'      => env('PATHAO_USERNAME'),
        'password'      => env('PATHAO_PASSWORD'),
        'grant_type'    => env('PATHAO_GRANT_TYPE'),
    ],

    'steadfast' => [
        'name'       => 'SteadFast',
        'base_url'   => env('STEAD_FAST_ENDPOINT'),
        'api_key'    => env('STEAD_FAST_API_KEY'),
        'secret_key' => env('STEAD_FAST_SECRET_KEY'),
    ],

    'redx' => [
        'name' => 'RedX',
        'base_url' => env('REDX_ENDPOINT'),
        'token' => env('REDX_TOKEN'),
    ],

    'paperfly' => [
        'name'     => 'Paperfly',
        'base_url' => env('PAPERFLY_ENDPOINT'),
        'username' => env('PAPERFLY_USERNAME'),
        'password' => env('PAPERFLY_PASSWORD'),
    ],
];
