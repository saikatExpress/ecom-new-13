<?php

namespace Database\Seeders\Product;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Product\Category;
use App\Models\Product\SubCategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = [
            'Electronics' => [
                'Mobile Phones',
                'Laptops',
                'Tablets',
                'Smart Watches',
                'Accessories',
            ],

            'Fashion' => [
                'Men Clothing',
                'Women Clothing',
                'Shoes',
                'Bags',
                'Watches',
            ],

            'Home & Living' => [
                'Furniture',
                'Kitchen',
                'Home Decor',
                'Lighting',
            ],

            'Beauty & Personal Care' => [
                'Skin Care',
                'Hair Care',
                'Makeup',
                'Perfume',
            ],

            'Health' => [
                'Vitamins',
                'Medical Equipment',
                'Personal Hygiene',
            ],

            'Sports & Outdoors' => [
                'Gym Equipment',
                'Football',
                'Cricket',
                'Cycling',
            ],

            'Books' => [
                'Programming',
                'Business',
                'Novel',
                'Islamic Books',
            ],

            'Toys & Games' => [
                'Educational Toys',
                'Remote Control',
                'Board Games',
            ],

            'Automotive' => [
                'Car Accessories',
                'Motorcycle Accessories',
                'Engine Oil',
            ],

            'Groceries' => [
                'Rice',
                'Oil',
                'Snacks',
                'Beverages',
            ],
        ];

        foreach ($subCategories as $categoryName => $items) {

            $category = Category::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            foreach ($items as $item) {

                SubCategory::create([
                    'category_id' => $category->id,
                    'name'        => $item,
                    'slug'        => Str::slug($item),
                    'status'      => StatusEnum::ACTIVE,
                ]);
            }
        }
    }
}
