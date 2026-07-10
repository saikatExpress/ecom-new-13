<?php

namespace App\Helpers;

class Helper
{
    /**
     * Generate all permissions from config/modules.
     */
    public static function generate(): array
    {
        $modules = config('laratrust_seeder.modules', []);
        $permissionsMap = config('laratrust_seeder.permissions_map', []);

        $permissions = [];

        foreach ($modules as $module => $actions) {

            $actions = array_filter(array_map('trim', explode(',', $actions)));

            foreach ($actions as $action) {

                $actionName = $permissionsMap[$action] ?? $action;

                $permissionName = "{$actionName}.{$module}";

                $permissions[$permissionName] = [
                    'name'         => $permissionName,
                    'module'       => $module,
                    'action'       => $actionName,
                    'display_name' => ucwords(str_replace(['.', '-'], ' ', $permissionName)),
                    'description'  => ucfirst($actionName) . ' permission for ' . ucwords(str_replace('_', ' ', $module)),
                ];
            }
        }

        return array_values($permissions);
    }

    /**
     * Get all permissions for a specific role.
     */
    public static function getRolePermissions(string $role): array
    {
        $roles = config('laratrust_seeder.roles', []);
        $permissionsMap = config('laratrust_seeder.permissions_map', []);

        if (! isset($roles[$role])) {
            return [];
        }

        $permissions = [];

        foreach ($roles[$role] as $module => $actions) {

            $actions = array_filter(array_map('trim', explode(',', $actions)));

            foreach ($actions as $action) {

                $actionName = $permissionsMap[$action] ?? $action;

                $permissions[] = "{$actionName}.{$module}";
            }
        }

        return array_values(array_unique($permissions));
    }

    /**
     * Get all available roles.
     */
    public static function getRoles(): array
    {
        return array_keys(config('laratrust_seeder.roles', []));
    }

    /**
     * Get all available modules.
     */
    public static function getModules(): array
    {
        return array_keys(config('laratrust_seeder.modules', []));
    }
}
