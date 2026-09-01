<?php

namespace Database\Seeders\CMS;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\CMS\Section;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = Product::query()->pluck('id')->toArray();

        $sections = [
            [
                'name'       => 'Featured Products',
                'link'       => '/products?featured=1',
                'is_slider'  => true,
                'img_path'   => 'sections/featured-products.jpg',
                'position'   => 1,
            ],
            [
                'name'       => 'New Arrivals',
                'link'       => '/products?sort=newest',
                'is_slider'  => true,
                'img_path'   => 'sections/new-arrivals.jpg',
                'position'   => 2,
            ],
            [
                'name'       => 'Best Selling Products',
                'link'       => '/products?sort=best-selling',
                'is_slider'  => true,
                'img_path'   => 'sections/best-selling-products.jpg',
                'position'   => 3,
            ],
            [
                'name'       => 'Trending Now',
                'link'       => '/products?trending=1',
                'is_slider'  => false,
                'img_path'   => 'sections/trending-now.jpg',
                'position'   => 4,
            ],
            [
                'name'       => 'Special Offers',
                'link'       => '/products?offers=1',
                'is_slider'  => true,
                'img_path'   => 'sections/special-offers.jpg',
                'position'   => 5,
            ],
        ];

        foreach ($sections as $sectionData) {

            $section = Section::updateOrCreate(
                [
                    'slug' => Str::slug($sectionData['name']),
                ],
                [
                    'name'       => $sectionData['name'],
                    'link'       => $sectionData['link'],
                    'is_slider'  => $sectionData['is_slider'],
                    'img_path'   => $sectionData['img_path'],
                    'position'   => $sectionData['position'],
                    'status'     => StatusEnum::ACTIVE->value,
                ]
            );

            if (!empty($productIds)) {

                $randomProductIds = collect($productIds)->shuffle()->take(min(8, count($productIds)))->values()->toArray();

                $section->products()->sync($randomProductIds);
            }
        }
    }
}
