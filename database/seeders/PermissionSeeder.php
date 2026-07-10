<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Helper::generate() as $permission) {

            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
