<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('laratrust_seeder.roles', []) as $roleName => $modules) {

            $role = Role::where('name', $roleName)->first();

            if (! $role) {
                continue;
            }

            $permissionIds = Permission::query()
                ->whereIn('name', Helper::getRolePermissions($roleName))
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}
