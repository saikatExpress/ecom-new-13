<?php

namespace App\Helpers\Laratrust;

class PermissionHelper
{
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
}
