<?php

namespace App\Services\Auth;

use App\Enums\OtpPurposeEnum;
use App\Exceptions\CustomException;
use App\Models\Auth\Otp;
use App\Models\User;
use App\Services\Sms\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class OtpService
{
    public function __construct(protected SmsService $smsService){}

    public function send(User $user, OtpPurposeEnum $purpose, Request $request): void
    {
        $lastOtp = Otp::query()
            ->where('phone_number', $user->phone_number)
            ->where('purpose', $purpose->value)
            ->pending()
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->sent_at && $lastOtp->sent_at->gt(now()->subSeconds(60))) {
            throw new CustomException('Please wait before requesting another OTP.',429);
        }

        Otp::query()
            ->where('phone_number', $user->phone_number)
            ->where('purpose', $purpose->value)
            ->pending()
            ->delete();

        $otp = random_int(100000, 999999);

        Otp::create([
            'user_id'      => $user->id,
            'phone_number' => $user->phone_number,
            'purpose'      => $purpose->value,
            'code_hash'    => Hash::make($otp),
            'expires_at'   => now()->addMinutes(5),
            'sent_at'      => now(),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ]);

        $this->smsService->sendOtp(
            $user->phone_number,
            (string) $otp
        );

        logger()->info("OTP: {$otp}");
    }

    public function verify(User $user,OtpPurposeEnum $purpose,string $otp): void {

        $record = Otp::query()
            ->where('phone_number', $user->phone_number)
            ->where('purpose', $purpose->value)
            ->pending()
            ->latest()
            ->first();

        if (! $record) {
            throw new CustomException('OTP not found.');
        }

        if ($record->expires_at->isPast()) {
            throw new CustomException('OTP has expired.');
        }

        if ($record->attempts >= $record->max_attempts) {
            throw new CustomException('Maximum OTP attempts exceeded.');
        }

        if (! Hash::check($otp, $record->code_hash)) {

            $record->increment('attempts');

            throw new CustomException('Invalid OTP.');
        }

        $record->update([
            'consumed_at' => now(),
        ]);
    }
}
