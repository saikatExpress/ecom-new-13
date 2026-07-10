<?php

namespace App\Helpers\Laratrust;

class RoleHelper
{
    public static function getRoles(): array
    {
        return array_keys(config('laratrust_seeder.roles', []));
    }

    public static function getModules(): array
    {
        return array_keys(config('laratrust_seeder.modules', []));
    }
}
