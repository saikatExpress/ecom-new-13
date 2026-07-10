<?php

namespace Database\Seeders;

use App\Helpers\Laratrust\PermissionHelper;
use App\Models\Permission;
use Illuminate\Database\Seeder;

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
