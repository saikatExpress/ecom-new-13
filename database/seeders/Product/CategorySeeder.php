<?php

namespace Database\Seeders\Product;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Product\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home & Living',
            'Beauty & Personal Care',
            'Health',
            'Sports & Outdoors',
            'Books',
            'Toys & Games',
            'Automotive',
            'Groceries',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'   => $category,
                'slug'   => Str::slug($category),
                'status' => StatusEnum::ACTIVE,
            ]);
        }
    }
}
