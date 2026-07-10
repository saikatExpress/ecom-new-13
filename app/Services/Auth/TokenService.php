<?php

namespace App\Services\Auth;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class TokenService
{
    public function create(User $user): NewAccessToken
    {
        return $user->createToken(config('app.name'));
    }

    public function createPlainText(User $user): string
    {
        return $this->create($user)->plainTextToken;
    }


    public function deleteAll(User $user): void
    {
        $user->tokens()->delete();
    }

    public function deleteCurrent(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    public function deleteById(User $user, int $tokenId): void
    {
        $user->tokens()
            ->where('id', $tokenId)
            ->delete();
    }

    public function deleteOthers(User $user): void
    {
        $currentTokenId = $user->currentAccessToken()?->id;

        $user->tokens()
            ->where('id', '!=', $currentTokenId)
            ->delete();
    }

    public function hasTokens(User $user): bool
    {
        return $user->tokens()->exists();
    }

    public function count(User $user): int
    {
        return $user->tokens()->count();
    }

    public function all(User $user)
    {
        return $user->tokens()
            ->latest()
            ->get();
    }

    public function refresh(User $user): string
    {
        $this->deleteAll($user);

        return $this->createPlainText($user);
    }
}
