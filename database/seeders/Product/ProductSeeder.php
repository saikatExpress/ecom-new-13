<?php

namespace Database\Seeders\Product;

use App\Models\Product\AttributeValue;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductGallery;
use App\Models\Product\ProductVariant;
use App\Models\Product\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds       = Category::pluck('id')->toArray();
        $subCategoryIds    = SubCategory::pluck('id')->toArray();
        $brandIds          = Brand::pluck('id')->toArray();
        $attributeValueIds = AttributeValue::pluck('id')->toArray();

        if (empty($categoryIds)) {
            $categoryIds = [1];
        }

        $productNames = [
            'Premium Cotton Panjabi', 'Casual Denim Shirt', 'Formal Office Suit',
            'Running Sports Shoes', 'Wireless Bluetooth Earbuds', 'Smart Fitness Watch',
            'Leather Wallet for Men', 'Stylish Sunglass', 'Cotton Polo T-Shirt', 'Graphic Printed Hoodie'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $name = $productNames[array_rand($productNames)] . ' - ' . $i;
            $mrp = rand(1000, 5000);
            $sellPrice = $mrp - rand(100, 500);

            $product = Product::create([
                'name'                => $name,
                'slug'                => Str::slug($name) . '-' . time() . '-' . $i,
                'category_id'         => $categoryIds[array_rand($categoryIds)],
                'sub_category_id'     => !empty($subCategoryIds) ? $subCategoryIds[array_rand($subCategoryIds)] : null,
                'brand_id'            => !empty($brandIds) ? $brandIds[array_rand($brandIds)] : null,
                'sku'                 => 'SKU-' . strtoupper(Str::random(8)) . '-' . $i,
                'buy_price'           => $sellPrice - rand(200, 600),
                'mrp'                 => $mrp,
                'sell_price'          => $sellPrice,
                'offer_percentage'    => 10,
                'discount_amount'     => 100.00,
                'offer_price'         => $sellPrice - 100,
                'current_stock'       => rand(10, 100),
                'total_sell_quantity' => rand(0, 50),
                'short_description'   => 'This is a short description for ' . $name,
                'description'         => 'Detailed product specifications and features for ' . $name . ' designed for Bangladesh market.',
                'meta_title'          => $name,
                'meta_description'    => 'Buy ' . $name . ' online at best price in Bangladesh.',
                'meta_keywords'       => 'ecommerce, bangladesh, ' . strtolower($name),
                'status'              => 'active',
            ]);

            for ($g = 1; $g <= 2; $g++) {
                ProductGallery::create([
                    'product_id' => $product->id,
                    'img_path' => 'uploads/products/sample-' . $g . '.jpg',
                ]);
            }

            if ($i % 2 == 0 && !empty($attributeValueIds)) {
                for ($v = 1; $v <= 2; $v++) {
                    $variantPrice = $sellPrice + rand(50, 200);

                    $variant = ProductVariant::create([
                        'product_id'          => $product->id,
                        'sku'                 => 'VAR-' . strtoupper(Str::random(6)) . '-' . $i . '-' . $v,
                        'buy_price'           => $variantPrice - 300,
                        'mrp'                 => $variantPrice + 500,
                        'sell_price'          => $variantPrice,
                        'discount_amount'     => 50.00,
                        'offer_price'         => $variantPrice - 50,
                        'offer_percentage'    => 10,
                        'current_stock'       => rand(5, 25),
                        'total_sell_quantity' => rand(0, 10),
                        'img_path'            => 'uploads/variants/variant-' . $v . '.jpg',
                        'status'              => 'active',
                    ]);

                    if (count($attributeValueIds) >= 2) {
                        $randomValues = array_rand(array_flip($attributeValueIds), min(2, count($attributeValueIds)));
                        $variant->attributeValues()->attach(is_array($randomValues) ? $randomValues : [$randomValues]);
                    }
                }
            }
        }
    }
}
