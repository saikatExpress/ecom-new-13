<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Auth\LoginRequest;
use App\Http\Resources\Backend\Auth\AuthResource;
use App\Http\Requests\Backend\Auth\ResendOtpRequest;
use App\Http\Requests\Backend\Auth\VerifyOtpRequest;
use App\Http\Requests\Backend\Auth\ResetPasswordRequest;
use App\Http\Requests\Backend\Auth\UpdatePasswordRequest;
use App\Http\Requests\Backend\Auth\ForgotPasswordRequest;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService){}

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request);

        if ($result['otp_required']) {

            return $this->sendResponse($result,'OTP sent successfully.');
        }

        return $this->sendResponse(new AuthResource($result['user']),'Login Successfully');
    }

    public function me()
    {
        $me = $this->authService->me();

        $me = new AuthResource($me);

        return $this->sendResponse($me, 'Login User Data');
    }

    public function update(UpdatePasswordRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_update', 'You have no permission for update password');

        $user = $this->authService->update($request, $id);

        return $this->sendResponse($user, "User Password update successfully");
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return $this->sendResponse([],'Logout successfully.',200);
    }

    public function logoutAllDevices(Request $request)
    {
        $this->authService->logoutAllDevices($request);

        return $this->sendResponse([],'Logged out from all devices successfully.',200);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = $this->authService->verifyOtp($request);

        $user = new AuthResource($user);

        return $this->sendResponse($user,'Login Successfully.',200);
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $this->authService->resendOtp($request);

        return $this->sendResponse([],'OTP sent successfully.',200);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->forgotPassword($request);

        return $this->sendResponse([], 'Password reset OTP sent successfully.', 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request);

        return $this->sendResponse([],'Password reset successfully.',200);
    }
}
