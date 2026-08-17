<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\UserCategory;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Customer',
            'Admin',
            'Employee',
        ];

        foreach ($categories as $category) {
            UserCategory::create([
                'name'   => $category,
                'slug'   => Str::slug($category),
                'status' => StatusEnum::ACTIVE->value,
            ]);
        }
    }
}
