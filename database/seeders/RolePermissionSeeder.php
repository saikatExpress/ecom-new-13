<?php

namespace Database\Seeders;

use App\Helpers\Laratrust\PermissionHelper;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('laratrust_seeder.roles', []) as $roleName => $modules) {

            $role = Role::where('name', $roleName)->first();

            if (! $role) {
                continue;
            }

            $permissionIds = Permission::query()
                ->whereIn(
                    'name',
                    PermissionHelper::getRolePermissions($roleName)
                )
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}
