<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsGateway implements SmsGatewayInterface
{
    public function send(
        string $phoneNumber,
        string $message
    ): bool {

        Log::info('SMS Sent', [
            'phone_number' => $phoneNumber,
            'message'      => $message,
        ]);

        return true;
    }
}
