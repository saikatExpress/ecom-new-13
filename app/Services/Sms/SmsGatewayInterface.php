<?php

namespace App\Services\Sms;

interface SmsGatewayInterface
{
    public function send(
        string $phoneNumber,
        string $message
    ): bool;
}
