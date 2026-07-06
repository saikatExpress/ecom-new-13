<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'appName'     => config('app.name'),
        'environment' => config('app.env'),
        'appUrl'      => config('app.url'),
        'debug'       => config('app.debug'),
        'locale'      => config('app.locale'),
        'database'    => [
            'connection' => config('database.default'),
            'name'       => config('database.connections.'.config('database.default').'.database'),
            'host'       => config('database.connections.'.config('database.default').'.host'),
        ],
        'cache'          => config('cache.default'),
        'queue'          => config('queue.default'),
        'session'        => config('session.driver'),
        'mail'           => config('mail.default'),
        'phpVersion'     => PHP_VERSION,
        'laravelVersion' => Application::VERSION,
        'packages'       => [
            'laravel/framework' => '^13.8',
            'laravel/tinker'    => '^3.0',
            'pestphp/pest'      => '^4.7',
        ],
    ]);
});
