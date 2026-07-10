<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Helper::getRoles() as $roleName) {

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
