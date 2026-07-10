<?php

namespace App\Enums;

enum OtpPurposeEnum: string
{
    case LOGIN = 'login';

    case REGISTER = 'register';

    case FORGOT_PASSWORD = 'forgot_password';

    case CHANGE_PHONE = 'change_phone';

    case EMAIL_VERIFICATION = 'email_verification';
}
