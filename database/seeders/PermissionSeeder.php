<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Helpers\Laratrust\PermissionHelper;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionHelper::generate() as $permission) {

            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
