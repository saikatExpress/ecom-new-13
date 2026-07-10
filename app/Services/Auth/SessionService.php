<?php

namespace App\Services\Auth;

use App\Models\User;

class SessionService
{
    public function __construct(
        private TokenService $tokenService
    ) {}

    /**
     * Logout current device.
     */
    public function logout(User $user): void
    {
        $this->tokenService->deleteCurrent($user);
    }

    /**
     * Logout all devices.
     */
    public function logoutAll(User $user): void
    {
        $this->tokenService->deleteAll($user);
    }

    /**
     * Logout all devices except current.
     */
    public function logoutOthers(User $user): void
    {
        $this->tokenService->deleteOthers($user);
    }

    /**
     * Refresh current session.
     */
    public function refresh(User $user): string
    {
        return $this->tokenService->refresh($user);
    }

    /**
     * Check user has active sessions.
     */
    public function hasActiveSessions(User $user): bool
    {
        return $this->tokenService->hasTokens($user);
    }

    /**
     * Total active sessions.
     */
    public function totalSessions(User $user): int
    {
        return $this->tokenService->count($user);
    }

    /**
     * Get active sessions.
     */
    public function sessions(User $user)
    {
        return $this->tokenService->all($user);
    }

    /**
     * Logout specific session.
     */
    public function logoutSession(User $user, int $tokenId): void
    {
        $this->tokenService->deleteById($user, $tokenId);
    }
}
