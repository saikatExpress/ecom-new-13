<?php

namespace App\Services\Auth;

use App\Enums\LoginFailureReasonEnum;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

class LoginHistoryService
{
    public function __construct(private LoginHistory $model,private DeviceService $deviceService) {}

    public function success(User $user, Request $request): void
    {
        $this->store(user: $user,request: $request,success: true);
    }

    public function userNotFound(string $phoneNumber, Request $request): void
    {
        $this->store(
            user: null,
            request: $request,
            success: false,
            phoneNumber: $phoneNumber,
            reason: LoginFailureReasonEnum::USER_NOT_FOUND
        );
    }

    public function wrongPassword(User $user, Request $request): void
    {
        $this->store(
            user: $user,
            request: $request,
            success: false,
            reason: LoginFailureReasonEnum::WRONG_PASSWORD
        );
    }

    public function deletedAccount(User $user, Request $request): void
    {
        $this->store(
            user: $user,
            request: $request,
            success: false,
            reason: LoginFailureReasonEnum::ACCOUNT_DELETED
        );
    }

    public function inactiveAccount(User $user, Request $request): void
    {
        $this->store(
            user: $user,
            request: $request,
            success: false,
            reason: LoginFailureReasonEnum::INACTIVE_ACCOUNT
        );
    }

    public function rateLimited(string $phoneNumber, Request $request): void
    {
        $this->store(
            user: null,
            request: $request,
            success: false,
            phoneNumber: $phoneNumber,
            reason: LoginFailureReasonEnum::RATE_LIMITED
        );
    }

    public function logout(User $user): void
    {
        $this->model
            ->where('user_id', $user->id)
            ->whereNull('logout_at')
            ->latest()
            ->first()
            ?->update([
                'logout_at' => now(),
            ]);
    }

    public function logoutAllDevices(User $user, Request $request): void
    {
        $this->model::create([
            'user_id'      => $user->id,
            'phone_number' => $user->phone_number,
            'status'       => 'logout_all_devices',
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ]);
    }

    private function store(?User $user, Request $request, bool $success, ?string $phoneNumber = null, ?LoginFailureReasonEnum $reason = null): void {

        $device = $this->deviceService->info($request);

        $this->model->create([

            'user_id'        => $user?->id,

            'phone_number'   => $phoneNumber ?? $user?->phone_number,

            'ip_address'     => $device['ip_address'],

            'user_agent'     => $device['user_agent'],

            'browser'        => $device['browser'],

            'browser_version'=> $device['browser_version'],

            'platform'       => $device['platform'],

            'platform_version'=> $device['platform_version'],

            'device'         => $device['device'],

            'success'        => $success,

            'failure_reason' => $reason?->value,

            'login_at'       => $success ? now() : null,
        ]);
    }
}
