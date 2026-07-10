<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PermissionService
{
    /**
     * Cache TTL (seconds)
     */
    protected int $ttl = 3600;

    /**
     * Get all permissions.
     */
    public function permissions(User $user): array
    {
        return Cache::remember(
            $this->permissionCacheKey($user),
            $this->ttl,
            fn () => $user->roles
                ->flatMap(fn ($role) => $role->permissions)
                ->pluck('name')
                ->unique()
                ->values()
                ->toArray()
        );
    }

    /**
     * Get all roles.
     */
    public function roles(User $user): array
    {
        return Cache::remember(
            $this->roleCacheKey($user),
            $this->ttl,
            fn () => $user->roles
                ->pluck('name')
                ->unique()
                ->values()
                ->toArray()
        );
    }

    /**
     * Has Permission
     */
    public function hasPermission(User $user, string $permission): bool
    {
        return in_array(
            $permission,
            $this->permissions($user),
            true
        );
    }

    /**
     * Has Any Permission
     */
    public function hasAnyPermission(User $user, array $permissions): bool
    {
        return count(array_intersect(
            $permissions,
            $this->permissions($user)
        )) > 0;
    }

    /**
     * Has All Permissions
     */
    public function hasAllPermissions(User $user, array $permissions): bool
    {
        return empty(array_diff(
            $permissions,
            $this->permissions($user)
        ));
    }

    /**
     * Has Role
     */
    public function hasRole(User $user, string $role): bool
    {
        return in_array(
            $role,
            $this->roles($user),
            true
        );
    }

    /**
     * Has Any Role
     */
    public function hasAnyRole(User $user, array $roles): bool
    {
        return count(array_intersect(
            $roles,
            $this->roles($user)
        )) > 0;
    }

    /**
     * Clear cache.
     */
    public function clear(User $user): void
    {
        Cache::forget(
            $this->permissionCacheKey($user)
        );

        Cache::forget(
            $this->roleCacheKey($user)
        );
    }

    /**
     * Permission Cache Key
     */
    protected function permissionCacheKey(User $user): string
    {
        return "permissions:{$user->id}";
    }

    /**
     * Role Cache Key
     */
    protected function roleCacheKey(User $user): string
    {
        return "roles:{$user->id}";
    }
}
