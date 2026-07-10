<?php

namespace App\Enums;

enum LoginFailureReasonEnum: string
{
    case USER_NOT_FOUND      = 'user_not_found';

    case WRONG_PASSWORD      = 'wrong_password';

    case INACTIVE_ACCOUNT    = 'inactive_account';

    case ACCOUNT_DELETED     = 'account_deleted';

    case ACCOUNT_LOCKED      = 'account_locked';

    case ACCOUNT_SUSPENDED   = 'account_suspended';

    case RATE_LIMITED        = 'rate_limited';

    case EMAIL_NOT_VERIFIED  = 'email_not_verified';

    case PHONE_NOT_VERIFIED  = 'phone_not_verified';

    case OTP_REQUIRED        = 'otp_required';

    case OTP_EXPIRED         = 'otp_expired';

    case OTP_INVALID         = 'otp_invalid';

    case TOKEN_EXPIRED       = 'token_expired';

    case TOKEN_INVALID       = 'token_invalid';

    case SESSION_EXPIRED     = 'session_expired';

    case TWO_FACTOR_REQUIRED = 'two_factor_required';

    case UNKNOWN             = 'unknown';

    /**
     * Human readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::USER_NOT_FOUND      => 'User Not Found',
            self::WRONG_PASSWORD      => 'Wrong Password',
            self::INACTIVE_ACCOUNT    => 'Inactive Account',
            self::ACCOUNT_DELETED     => 'Account Deleted',
            self::ACCOUNT_LOCKED      => 'Account Locked',
            self::ACCOUNT_SUSPENDED   => 'Account Suspended',
            self::RATE_LIMITED        => 'Rate Limited',
            self::EMAIL_NOT_VERIFIED  => 'Email Not Verified',
            self::PHONE_NOT_VERIFIED  => 'Phone Not Verified',
            self::OTP_REQUIRED        => 'OTP Required',
            self::OTP_EXPIRED         => 'OTP Expired',
            self::OTP_INVALID         => 'OTP Invalid',
            self::TOKEN_EXPIRED       => 'Token Expired',
            self::TOKEN_INVALID       => 'Invalid Token',
            self::SESSION_EXPIRED     => 'Session Expired',
            self::TWO_FACTOR_REQUIRED => 'Two Factor Required',
            self::UNKNOWN             => 'Unknown'
        };
    }
}
