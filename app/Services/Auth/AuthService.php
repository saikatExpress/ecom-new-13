<?php

namespace App\Services\Auth;

use App\Enums\OtpPurposeEnum;
use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Helpers\Setting\SettingHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthService
{
    public function __construct
    (
        private User $model,
        private TokenService $tokenService,
        private LoginHistoryService $loginHistoryService,
        private OtpService $otpService
    ) {}

    public function login($request): array
    {
        $key = strtolower($request->phone_number) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {

            $this->loginHistoryService->rateLimited(
                $request->phone_number,
                $request
            );

            $seconds = RateLimiter::availableIn($key);

            throw new CustomException(
                "Too many login attempts. Please try again after {$seconds} seconds.",
                429
            );
        }

        $user = $this->model
            ->newQuery()
            ->with('roles.permissions')
            ->withTrashed()
            ->where('phone_number', $request->phone_number)
            ->first();

        if (! $user) {

            RateLimiter::hit($key, 300);

            $this->loginHistoryService->userNotFound($request->phone_number,$request);

            throw new CustomException('Phone number or password is incorrect.');
        }

        if (! Hash::check($request->password, $user->password)) {

            RateLimiter::hit($key, 300);

            $this->loginHistoryService->wrongPassword($user,$request);

            throw new CustomException('Phone number or password is incorrect.');
        }

        if ($user->trashed()) {

            $this->loginHistoryService->deletedAccount($user,$request);

            throw new CustomException('Your account has been deleted.',403);
        }

        if ($user->status !== StatusEnum::ACTIVE->value) {

            $this->loginHistoryService->inactiveAccount($user,$request);

            throw new CustomException('Your account has been disabled.',403);
        }

        $excludedRoleIds = [1, 2, 3];

        $requiresOtp = SettingHelper::setting('login_otp_enabled', false) && $user->roles->pluck('id')->intersect($excludedRoleIds)->isEmpty();

        if ($requiresOtp) {

            $this->otpService->send(user: $user,purpose: OtpPurposeEnum::LOGIN,request: $request);

            return [
                'otp_required' => true,
                'phone_number' => $user->phone_number,
                'message' => 'OTP has been sent successfully.',
            ];
        }

        $user = $this->completeLogin($user, $request, $key);

        return [
            'otp_required' => false,
            'user' => $user,
        ];
    }

    private function completeLogin(User $user, $request, string $key): User
    {
        RateLimiter::clear($key);

        $user->update([
            'last_login_at' => now(),
        ]);

        $user->access_token = $this->tokenService->create($user);

        $this->loginHistoryService->success($user, $request);

        $user->load('roles.permissions');

        return $user;
    }

    public function verifyOtp($request): User
    {
        $user = $this->model
            ->with('roles.permissions')
            ->where('phone_number', $request->phone_number)
            ->firstOrFail();

        $this->otpService->verify(
            user: $user,
            purpose: OtpPurposeEnum::from($request->purpose),
            otp: $request->otp
        );

        $key = strtolower($request->phone_number) . '|' . $request->ip();

        return $this->completeLogin(
            $user,
            $request,
            $key
        );
    }

    public function me(): User
    {
        return auth()
            ->user()
            ->load([
                'roles.permissions'
            ]);
    }

    public function resendOtp($request): void
    {
        $user = $this->model->where('phone_number', $request->phone_number)->firstOrFail();

        $this->otpService->send(
            user: $user,
            purpose: OtpPurposeEnum::from($request->purpose),
            request: $request
        );
    }

    public function forgotPassword($request): void
    {
        $user = $this->model
            ->where('phone_number', $request->phone_number)
            ->firstOrFail();

        if ($user->trashed()) {
            throw new CustomException(
                'Your account has been deleted.',
                403
            );
        }

        if ($user->status !== StatusEnum::ACTIVE->value) {
            throw new CustomException(
                'Your account has been disabled.',
                403
            );
        }

        $this->otpService->send(
            user: $user,
            purpose: OtpPurposeEnum::FORGOT_PASSWORD,
            request: $request
        );
    }

    public function resetPassword($request): void
    {
        $user = $this->model
            ->where(
                'password_reset_token',
                hash('sha256', $request->reset_token)
            )
            ->first();

        if (! $user) {
            throw new CustomException(
                'Invalid reset token.',
                422
            );
        }

        if (
            ! $user->password_reset_token_expires_at ||
            $user->password_reset_token_expires_at->isPast()
        ) {
            throw new CustomException(
                'Reset token has expired.',
                422
            );
        }

        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_token_expires_at' => null,
        ]);

        $user->tokens()->delete();
    }

    public function logout($request): void
    {
        $user = $request->user();

        $user->update([
            'last_logout_at' => now(),
        ]);

        $this->loginHistoryService->logout($user);

        $user->currentAccessToken()?->delete();
    }

    public function logoutAllDevices($request): void
    {
        $user = $request->user();

        $user->update([
            'last_logout_at' => now(),
        ]);

        $this->loginHistoryService->logoutAllDevices(
            $user,
            $request
        );

        $user->tokens()->delete();
    }
}
