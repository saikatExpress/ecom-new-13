<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Sms\LogSmsGateway;
use App\Services\Sms\SmsGatewayInterface;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SmsGatewayInterface::class,
            LogSmsGateway::class
        );
    }

    public function boot(): void
    {
        //
    }
}
