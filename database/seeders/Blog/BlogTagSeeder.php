<?php

namespace Database\Seeders\Blog;

use App\Enums\StatusEnum;
use App\Models\Blog\BlogTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Smartphone',
            'Fashion',
            'Winter Collection',
            'Summer Style',
            'Gadgets',
            'Home Appliance',
            'Beauty & Care',
            'Flash Sale',
            'Eid Collection',
            'Gift Ideas',
            'Smart Home',
            'Discount',
            'New Arrival',
            'Tech News',
            'Buying Guide',
            'Best Deals',
            'Fitness Gear'
        ];

        foreach ($tags as $tag) {
            BlogTag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                [
                    'name'   => $tag,
                    'status' => StatusEnum::ACTIVE,
                ]
            );
        }
    }
}
