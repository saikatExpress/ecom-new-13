<?php

namespace Database\Seeders;

use Database\Seeders\Blog\BlogCategorySeeder;
use Database\Seeders\Blog\BlogPostSeeder;
use Database\Seeders\Blog\BlogTagSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\Product\AttributeSeeder;
use Database\Seeders\Product\SubCategorySeeder;
use Database\Seeders\Product\AttributeValueSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            BlogCategorySeeder::class,
            BlogTagSeeder::class,
            BlogPostSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
