<?php

namespace App\Services\Sms;

class SmsService
{
    public function __construct(
        protected SmsGatewayInterface $gateway
    ) {
    }

    public function sendOtp(
        string $phoneNumber,
        string $otp
    ): bool {

        $message = "Your verification code is {$otp}. It expires in 5 minutes.";

        return $this->gateway->send(
            $phoneNumber,
            $message
        );
    }

    public function send(
        string $phoneNumber,
        string $message
    ): bool {

        return $this->gateway->send(
            $phoneNumber,
            $message
        );
    }
}
