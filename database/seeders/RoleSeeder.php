<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Helpers\Laratrust\RoleHelper;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleHelper::getRoles() as $roleName) {

            Role::updateOrCreate(
                ['name' => $roleName],
                [
                    'display_name' => Str::headline($roleName),
                    'description'  => Str::headline($roleName) . ' Role',
                ]
            );
        }
    }
}
