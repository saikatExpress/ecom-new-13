<?php

namespace Database\Seeders\Product;

use Illuminate\Support\Str;
use App\Models\Product\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Samsung',
            'Apple',
            'Xiaomi',
            'Realme',
            'Vivo',
            'Oppo',
            'OnePlus',
            'Nokia',
            'Huawei',
            'Infinix',
            'Tecno',
            'Walton',
            'Sony',
            'LG',
            'Panasonic',
            'Canon',
            'Nikon',
            'HP',
            'Dell',
            'Lenovo',
            'Asus',
            'Acer',
            'MSI',
            'Intel',
            'AMD',
            'JBL',
            'Anker',
            'Baseus',
            'Remax',
            'Adata',
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($brand)],
                [
                    'name'     => $brand,
                    'slug'     => Str::slug($brand),
                    'img_path' => null,
                    'status'   => 'active',
                ]
            );
        }
    }
}
