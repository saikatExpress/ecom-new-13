<?php

namespace Database\Seeders\Product;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Product\Attribute;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            'Color',
            'Size',
            'Storage',
            'RAM',
            'Material',
            'Weight',
            'Length',
            'Capacity',
        ];

        foreach ($attributes as $attribute) {
            Attribute::create([
                'name' => $attribute,
                'slug' => Str::slug($attribute),
            ]);
        }
    }
}
