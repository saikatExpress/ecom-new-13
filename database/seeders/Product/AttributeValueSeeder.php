<?php

namespace Database\Seeders\Product;

use Illuminate\Database\Seeder;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeValue;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = [

            'Color' => [
                'Black',
                'White',
                'Blue',
                'Red',
                'Green',
                'Yellow',
                'Pink',
                'Gray',
                'Silver',
                'Gold',
            ],

            'Size' => [
                'XS',
                'S',
                'M',
                'L',
                'XL',
                'XXL',
            ],

            'Storage' => [
                '32 GB',
                '64 GB',
                '128 GB',
                '256 GB',
                '512 GB',
                '1 TB',
            ],

            'RAM' => [
                '2 GB',
                '4 GB',
                '6 GB',
                '8 GB',
                '12 GB',
                '16 GB',
                '24 GB',
            ],

            'Material' => [
                'Cotton',
                'Leather',
                'Plastic',
                'Wood',
                'Metal',
                'Glass',
            ],

            'Weight' => [
                '250 g',
                '500 g',
                '1 kg',
                '2 kg',
                '5 kg',
            ],

            'Length' => [
                '1 Meter',
                '2 Meter',
                '5 Meter',
                '10 Meter',
            ],

            'Capacity' => [
                '250 ml',
                '500 ml',
                '750 ml',
                '1 Liter',
                '2 Liter',
            ],

        ];

        foreach ($values as $attributeName => $attributeValues) {

            $attribute = Attribute::where('name', $attributeName)->first();

            if (! $attribute) {
                continue;
            }

            foreach ($attributeValues as $value) {

                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value'        => $value,
                ]);
            }
        }
    }
}
