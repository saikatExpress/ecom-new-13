<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Auth\ForgotPasswordRequest;
use App\Http\Requests\Backend\Auth\LoginRequest;
use App\Http\Requests\Backend\Auth\ResendOtpRequest;
use App\Http\Requests\Backend\Auth\ResetPasswordRequest;
use App\Http\Requests\Backend\Auth\VerifyOtpRequest;
use App\Http\Resources\Backend\Auth\AuthResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService){}

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request);

        if ($result['otp_required']) {

            return $this->sendResponse(
                $result,
                'OTP sent successfully.'
            );
        }

        return $this->sendResponse(
            new AuthResource($result['user']),
            'Login Successfully'
        );
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return $this->sendResponse(
            [],
            'Logout successfully.',
            200
        );
    }

    public function logoutAllDevices(Request $request)
    {
        $this->authService->logoutAllDevices($request);

        return $this->sendResponse(
            [],
            'Logged out from all devices successfully.',
            200
        );
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = $this->authService->verifyOtp($request);

        return $this->sendResponse(
            new AuthResource($user),
            'Login Successfully.',
            200
        );
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $this->authService->resendOtp($request);

        return $this->sendResponse(
            [],
            'OTP sent successfully.',
            200
        );
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->forgotPassword($request);

        return $this->sendResponse(
            [],
            'Password reset OTP sent successfully.',
            200
        );
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request);

        return $this->sendResponse(
            [],
            'Password reset successfully.',
            200
        );
    }
}
