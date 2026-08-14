<?php

namespace Database\Seeders\Blog;

use App\Enums\StatusEnum;
use App\Models\Blog\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Shopping Guides',
                'description' => 'Sothik product beche nite amader expert buying guide gulo porun.',
            ],
            [
                'name'        => 'Product Reviews',
                'description' => 'Natun product-er in-depth review, unboxing ebong pros/cons.',
            ],
            [
                'name'        => 'Tips & Tricks',
                'description' => 'Product baboharer bibhinno life hacks ebong tips.',
            ],
            [
                'name'        => 'Offers & Promotions',
                'description' => 'Amader latest discount, flash sale ebong campaign-er update.',
            ],
            [
                'name'        => 'Trends & Lifestyle',
                'description' => 'Bortoman shomoyer latest trend ebong lifestyle news.',
            ],
            [
                'name'        => 'Company News',
                'description' => 'Amader brand-er notun update ebong announcement gulo.',
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name'        => $category['name'],
                    'description' => $category['description'],
                    'status'      => StatusEnum::ACTIVE,
                ]
            );
        }
    }
}
