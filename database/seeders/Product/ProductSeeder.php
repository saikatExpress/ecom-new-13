<?php

namespace Database\Seeders\Product;

use App\Enums\StatusEnum;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeValue;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductGallery;
use App\Models\Product\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::with('subCategories')->get();
        $brands     = Brand::all();
        $attributes = Attribute::with('attributeValues')->get();

        if ($categories->isEmpty()) {
            $this->command->error('No categories found! Please run CategorySeeder first.');
            return;
        }

        $attributeValuesByName = [];
        foreach ($attributes as $attr) {
            $attributeValuesByName[strtolower($attr->name)] = $attr->attributeValues->pluck('id')->toArray();
        }

        $bangladeshiProductsCatalog = [
            'Fashion' => [
                'Men Clothing' => [
                    'Aarong Premium Cotton Panjabi',
                    'Traditional Silk Designer Kabli Set',
                    'Richman Slim Fit Formal Cotton Shirt',
                    'Cats Eye Casual Checked Denim Shirt',
                    'Aarong Handloom Long Panjabi',
                    'Premium Katthan Silk Party Panjabi',
                    'Traditional White Dhoti Panjabi Set',
                    'Mens Casual Pique Polo T-Shirt',
                    'Fleece Graphic Printed Hoodie',
                    'Traditional Cotton Pajama Pair',
                    'Exclusive Embroidered Kurta for Men',
                    'Formal Office Suit Jacket',
                    'Mens Winter Heavy Puffer Jacket',
                ],
                'Women Clothing' => [
                    'Rajshahi Pure Silk Katthan Saree',
                    'Traditional Dhakai Handloom Jamdani Saree',
                    'Tangail Handcrafted Cotton Saree',
                    'Aarong Designer Embroidered Kurti',
                    'Exclusive Salwar Kameez Three-Piece',
                    'Kashmiri Heavy Work Anarkali Dress',
                    'Georgette Party Wear Long Gown',
                    'Cotton Daily Wear Casual Kurti',
                    'Pure Kanchipuram Silk Saree',
                    'Chiffon Dupatta & Lawn Suit Set',
                    'Traditional Manipuri Weave Saree',
                    'Designer Velvet Party Wear Kurti',
                    'Linen Casual Palazzo & Top Set',
                ],
                'Shoes' => [
                    'Apex Premium Genuine Leather Formal Shoes',
                    'Bay Emporium Casual Leather Loafers',
                    'Apex Ladies Stylish Block Heel Sandals',
                    'Bata Mens Comfortable Daily Walking Shoes',
                    'Lotto Sports Running Sneakers',
                    'Genuine Leather Traditional Nagra Shoes',
                ],
                'Bags' => [
                    'Apex Genuine Leather Mens Slim Wallet',
                    'Aarong Handcrafted Jute & Leather Tote Bag',
                    'Exclusive Ladies Leather Shoulder Handbag',
                    'Waterproof Travel Backpack with Laptop Sleeve',
                    'Traditional Nakshi Kantha Embroidered Sling Bag',
                ],
                'Watches' => [
                    'Apex Mens Classic Analog Wrist Watch',
                    'Womens Rose Gold Stainless Steel Watch',
                    'Waterproof Sports Digital Watch for Men',
                ],
            ],

            'Groceries' => [
                'Rice' => [
                    'Nazirshail Premium Miniket Rice (5kg)',
                    'Kalizira Aromatic Chinigura Rice (1kg)',
                    'BR-28 Premium Parboiled White Rice (10kg)',
                    'Kataribogh Premium Rice Bag (5kg)',
                    'Brown Whole Grain Organic Rice (2kg)',
                ],
                'Oil' => [
                    'Rupchanda Pure Soyabean Oil (5L)',
                    'Radhuni Kachi Ghani Pure Mustard Oil (1L)',
                    'ACI Nutrilife Fortified Rice Bran Oil (3L)',
                    'Fresh Premium Soyabean Oil Can (5L)',
                    'Parachute Extra Virgin Coconut Cooking Oil (500ml)',
                ],
                'Snacks' => [
                    'PRAN Spicy Mixed Chanachur Pack (300g)',
                    'Radhuni Crunchy Fried Potato Chips Pack',
                    'Bombay Sweets Ring Chips Family Pack',
                    'Well Food Butter Toast Biscuits Box',
                    'All Time Premium Dry Cake Biscuits',
                    'PRAN Dal Bhija Crunchy Snack (150g)',
                ],
                'Beverages' => [
                    'PRAN 100% Real Mango Fruit Juice (1L)',
                    'Ispahani Mirzapore Premium Black Tea (500g)',
                    'TeeTulia Organic Green Tea (25 Tea Bags)',
                    'Foster Clarks Instant Orange Drink Powder (500g)',
                    'Ahmed Foods Special Mango Pickle Jar (400g)',
                    'ACI Pure Mixed Fruit Drinks Pack (1L)',
                    'Taaza Strong Blend Black Tea Bag (100 Bags)',
                ],
            ],

            'Electronics' => [
                'Mobile Phones' => [
                    'Walton Primo GM4 4G Smartphone',
                    'Walton Orbit Y21 Android Smartphone',
                    'Walton Primo RX9 Performance Edition',
                    'Samsung Galaxy A14 5G Bangladesh Official',
                    'Xiaomi Redmi Note 12 Pro 5G',
                    'Realme C55 Smartphone (8GB RAM)',
                    'Vivo Y27 4G Smartphone',
                ],
                'Laptops' => [
                    'Walton Tamarind EX5 Core i5 Laptop',
                    'Walton Prelude N50 Ultra Slim Notebook',
                    'HP Pavilion 15 Core i5 Laptop',
                    'Dell Inspiron 15 Business Laptop',
                    'Lenovo IdeaPad Slim 3 Core i3',
                ],
                'Tablets' => [
                    'Walton Walpad 10H Android Tablet',
                    'Samsung Galaxy Tab A8 10.5 Inch',
                ],
                'Smart Watches' => [
                    'Walton Smart Fitness Tracker Watch',
                    'Baseus Smart Calling Watch with Heart Rate Monitor',
                    'Anker Soundcore Fitness Smartwatch',
                ],
                'Accessories' => [
                    'Baseus 20000mAh Fast Charging Power Bank',
                    'Anker 20W PD Type-C Quick Charger',
                    'JBL Wave 200 True Wireless Earbuds',
                    'Remax Braided USB-C Fast Data Cable (2M)',
                    'Adata 64GB High Speed MicroSD Card',
                ],
            ],

            'Beauty & Personal Care' => [
                'Skin Care' => [
                    'Square Keya Super Beauty Soap Bar (150g)',
                    'Meril Protective Petroleum Jelly Jar (100g)',
                    'Tibbat Snow Natural Beauty Cream (50g)',
                    'Square Revive Glowing Skin Face Wash (100ml)',
                    'Cucumber Herbal Hydrating Facial Toner',
                    'Meril Splash Body Lotion Almond Oil (200ml)',
                ],
                'Hair Care' => [
                    'Parachute Pure Coconut Hair Oil (200ml)',
                    'Square Clear Herbal Anti-Dandruff Shampoo (180ml)',
                    'All-Natural Black Seed Hair Growth Oil (100ml)',
                ],
                'Makeup' => [
                    'Keya Compact Powder Fair Shade',
                    'Matte Waterproof Longlasting Red Lipstick',
                    'Herbal Organic Kajal Pencil',
                ],
                'Perfume' => [
                    'Aarong Earth Organic Rose Body Mist',
                    'Al-Rehab Crown Perfume Alcohol Free Attar (6ml)',
                    'Premium White Oudh Alcohol Free Fragrance',
                ],
            ],

            'Home & Living' => [
                'Furniture' => [
                    'Otobi Solid Teak Wood 6-Seater Dining Table',
                    'Otobi Ergonomic High Back Executive Office Chair',
                    'Hatil Premium Velvet Fabric 3-Seater Sofa',
                    'RFL Modern Heavy Duty Plastic Chair',
                    'Otobi Modern Wooden Bedside Table',
                ],
                'Kitchen' => [
                    'RFL Storage Airtight Container Box Set (5 Pcs)',
                    'Vision Heavy Duty Electric Blender & Grinder (750W)',
                    'Singer Digital Microwave Oven (20L)',
                    'Kiam Non-Stick Aluminum Cooking Pressure Cooker (5L)',
                    'Handcrafted Traditional Brass Tea Pot Set',
                ],
                'Home Decor' => [
                    'Handcrafted Nakshi Kantha Embroidered Wall Hanging',
                    'Brass Traditional Peacock Table Lamp',
                    'Handwoven Jute Floor Rug (4x6 Feet)',
                ],
                'Lighting' => [
                    'Energy Saving Cool White LED Ceiling Bulb (18W)',
                    'Vision Rechargeable Emergency LED Table Lamp',
                ],
            ],

            'Health' => [
                'Vitamins' => [
                    'Square Seclo 20mg Antacid Capsules (Box of 50)',
                    'ACI Multivitamin & Mineral Supplements',
                    'Pure Organic Moringa Leaf Powder Jar (250g)',
                ],
                'Medical Equipment' => [
                    'Digital Arm Blood Pressure Monitor',
                    'Fingertip Pulse Oximeter with LED Display',
                    'Infrared Non-Contact Forehead Thermometer',
                ],
                'Personal Hygiene' => [
                    'Bio-Clean Antibacterial Liquid Handwash (250ml)',
                    'Square Chaka Extra Power Laundry Bar Soap',
                    'Merit Herbal Antibacterial Bathing Soap',
                ],
            ],

            'Sports & Outdoors' => [
                'Gym Equipment' => [
                    'Pro Gym Rubber Encased Dumbbell Set (10kg)',
                    'Adjustable Fitness Jump Rope with Counter',
                    'Non-Slip Rubber Yoga Mat with Strap (6mm)',
                ],
                'Football' => [
                    'Official Size 5 Leather Match Football',
                    'Professional Football Shin Guards Pair',
                ],
                'Cricket' => [
                    'BD Cricket Official Match Leather Ball (Red)',
                    'Kashmir Willow Mens Cricket Bat',
                    'Full Cricket Kit Bag with Protective Pads',
                ],
                'Cycling' => [
                    'Lightweight Aluminum Alloy Mountain Bicycle (26 Inch)',
                    'Waterproof Bike Headlight & Horn Combo',
                ],
            ],

            'Books' => [
                'Programming' => [
                    'Habluder Jonno Programming by Jhankar Mahbub',
                    'Computer Programming 1st Part by Tamim Shahriar Subeen',
                ],
                'Business' => [
                    'Smart Entrepreneurship Guide for Bangladesh Market',
                    'Digital Marketing Secrets in Bangla',
                ],
                'Novel' => [
                    'Misir Ali Omnibus Part 1 by Humayun Ahmed',
                    'Himu Somogro Deluxe Hardcover Edition',
                    'Deyal Historical Novel by Humayun Ahmed',
                ],
                'Islamic Books' => [
                    'Islamic Foundation Al-Quran Bangla Translation & Tafsir',
                    'Ar-Raheeq Al-Makhtum Prophet Biography',
                ],
            ],

            'Toys & Games' => [
                'Educational Toys' => [
                    'Wooden Bangla Alphabet Learning Board puzzle',
                    'Kids DIY STEAM Solar Powered Robot Kit',
                ],
                'Remote Control' => [
                    'High Speed 4WD Remote Control Stunt Car',
                    'Mini Rechargeable RC Quadcopter Drone',
                ],
                'Board Games' => [
                    'Ludo & Snakes Ladder Wooden Board Game',
                    'Magnetized Tournament Chess Set',
                ],
            ],

            'Automotive' => [
                'Car Accessories' => [
                    'Premium Waterproof Heavy Duty Car Cover',
                    'High Pressure Portable Car Washer Pump (12V)',
                ],
                'Motorcycle Accessories' => [
                    'DOT Certified Full Face Motorcycle Helmet',
                    'Waterproof Bike Seat Cover & Handle Grip',
                ],
                'Engine Oil' => [
                    'Motul 4T 10W40 Synthetic Motorcycle Engine Oil (1L)',
                    'Mobil 1 Super 2000 Car Engine Oil (4L)',
                ],
            ],
        ];

        $productItemsToGenerate = [];
        $targetCount            = 250;
        $counter                = 1;

        while (count($productItemsToGenerate) < $targetCount) {
            foreach ($bangladeshiProductsCatalog as $catName => $subCats) {
                foreach ($subCats as $subCatName => $items) {
                    foreach ($items as $itemTitle) {
                        if (count($productItemsToGenerate) >= $targetCount) {
                            break 3;
                        }

                        $uniqueName               = $itemTitle . ($counter > count($items) ? ' - Batch ' . ceil($counter / 50) : '');
                        $productItemsToGenerate[] = [
                            'name'        => $uniqueName,
                            'category'    => $catName,
                            'subCategory' => $subCatName,
                            'index'       => $counter,
                        ];

                        $counter++;
                    }
                }
            }
        }

        $this->command->info('Seeding ' . count($productItemsToGenerate) . ' products...');

        foreach ($productItemsToGenerate as $i => $itemData) {
            $productIndex = $i + 1;
            $name         = $itemData['name'];
            $catName      = $itemData['category'];
            $subCatName   = $itemData['subCategory'];

            $category = $categories->firstWhere('name', $catName) ?? $categories->first();

            $subCategory = null;
            if ($category && $category->subCategories) {
                $subCategory = $category->subCategories->firstWhere('name', $subCatName) ?? $category->subCategories->first();
            }

            $brand = null;
            if ($brands->isNotEmpty()) {
                if (str_contains(strtolower($name), 'walton')) {
                    $brand = $brands->firstWhere('name', 'Walton');
                } elseif (str_contains(strtolower($name), 'aarong')) {
                    $brand = $brands->firstWhere('name', 'Aarong');
                } elseif (str_contains(strtolower($name), 'apex')) {
                    $brand = $brands->firstWhere('name', 'Apex');
                } elseif (str_contains(strtolower($name), 'pran')) {
                    $brand = $brands->firstWhere('name', 'PRAN');
                } elseif (str_contains(strtolower($name), 'radhuni')) {
                    $brand = $brands->firstWhere('name', 'Radhuni');
                } elseif (str_contains(strtolower($name), 'square') || str_contains(strtolower($name), 'meril') || str_contains(strtolower($name), 'keya')) {
                    $brand = $brands->firstWhere('name', 'Square');
                } elseif (str_contains(strtolower($name), 'otobi')) {
                    $brand = $brands->firstWhere('name', 'Otobi');
                } elseif (str_contains(strtolower($name), 'rfl')) {
                    $brand = $brands->firstWhere('name', 'RFL');
                } elseif (str_contains(strtolower($name), 'vision')) {
                    $brand = $brands->firstWhere('name', 'Vision Electronics');
                }

                if (!$brand) {
                    $brand = $brands->random();
                }
            }

            $mrp             = rand(300, 15000);
            $discountPct     = ($productIndex % 4 === 0) ? rand(5, 25) : 0;
            $discountAmount  = round(($mrp * $discountPct) / 100, 2);
            $sellPrice       = $mrp - $discountAmount;
            $buyPrice        = round($sellPrice * rand(70, 85) / 100, 2);
            $offerPrice      = $discountPct > 0 ? $sellPrice : null;
            $offerPercentage = $discountPct > 0 ? $discountPct : null;

            $isVariantProduct = ($productIndex % 2 === 0);

            $product = Product::create([
                'name'                => $name,
                'slug'                => Str::slug($name) . '-' . sprintf('%04d', $productIndex),
                'category_id'         => $category->id,
                'sub_category_id'     => $subCategory?->id,
                'brand_id'            => $brand?->id,
                'sku'                 => 'SKU-BD-' . strtoupper(Str::random(5)) . '-' . sprintf('%04d', $productIndex),
                'img_path'            => 'uploads/products/product-' . (($productIndex % 30) + 1) . '.jpg',
                'free_shipping'       => ($productIndex % 3 === 0) ? 1 : 0,
                'buy_price'           => $buyPrice,
                'mrp'                 => $mrp,
                'sell_price'          => $sellPrice,
                'offer_price'         => $offerPrice,
                'discount_amount'     => $discountAmount,
                'offer_percentage'    => $offerPercentage,
                'current_stock'       => rand(15, 300),
                'total_sell_quantity' => rand(0, 120),
                'short_description'   => "Authentic {$name} available at best price in Bangladesh. High quality and 100% original product.",
                'description'         => "Buy <strong>{$name}</strong> online in Bangladesh. Crafted with premium materials and designed to fulfill daily needs with reliability and satisfaction. Express delivery and cash on delivery available nationwide.",
                'video_url'           => ($productIndex % 5 === 0) ? 'https://www.youtube.com/watch?v=sample-bd-' . $productIndex : null,
                'meta_title'          => $name . ' | Buy Online in Bangladesh',
                'meta_description'    => "Get original {$name} at discount price in Bangladesh. Fast home delivery across Dhaka, Chittagong, Sylhet, and nationwide.",
                'meta_keywords'       => strtolower($name) . ', ecommerce bangladesh, buy online bd, best price bangladesh',
                'status'              => StatusEnum::ACTIVE->value,
            ]);

            $galleryCount = rand(2, 3);
            for ($g = 1; $g <= $galleryCount; $g++) {
                ProductGallery::create([
                    'product_id' => $product->id,
                    'img_path'   => 'uploads/galleries/gallery-' . ((($productIndex + $g) % 20) + 1) . '.jpg',
                ]);
            }

            if ($isVariantProduct) {
                $variantCount = rand(2, 4);

                for ($v = 0; $v < $variantCount; $v++) {
                    $variantMrp            = $mrp + ($v * 150);
                    $variantDiscountPct    = $discountPct;
                    $variantDiscountAmount = round(($variantMrp * $variantDiscountPct) / 100, 2);
                    $variantSellPrice      = $variantMrp - $variantDiscountAmount;
                    $variantBuyPrice       = round($variantSellPrice * 0.75, 2);
                    $variantOfferPrice     = $variantDiscountPct > 0 ? $variantSellPrice : null;

                    $variant = ProductVariant::create([
                        'product_id'          => $product->id,
                        'sku'                 => 'VAR-BD-' . strtoupper(Str::random(4)) . '-' . sprintf('%04d', $productIndex) . '-' . ($v + 1),
                        'buy_price'           => $variantBuyPrice,
                        'mrp'                 => $variantMrp,
                        'sell_price'          => $variantSellPrice,
                        'is_default'          => ($v === 0) ? 1 : 0,
                        'discount_amount'     => $variantDiscountAmount,
                        'offer_price'         => $variantOfferPrice,
                        'offer_percentage'    => $variantDiscountPct > 0 ? $variantDiscountPct : null,
                        'current_stock'       => rand(10, 80),
                        'short_description'   => "Option " . ($v + 1) . " for " . $name,
                        'description'         => "Variant specification " . ($v + 1) . " of " . $name . " designed for optimal convenience.",
                        'img_path'            => 'uploads/variants/variant-' . ((($productIndex + $v) % 20) + 1) . '.jpg',
                        'status'              => StatusEnum::ACTIVE->value,
                    ]);

                    $attachAttributeValueIds = [];

                    if ($catName === 'Fashion') {
                        if (!empty($attributeValuesByName['color'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['color'][$v % count($attributeValuesByName['color'])];
                        }
                        if (!empty($attributeValuesByName['size'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['size'][$v % count($attributeValuesByName['size'])];
                        }
                    } elseif ($catName === 'Electronics') {
                        if (!empty($attributeValuesByName['storage'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['storage'][$v % count($attributeValuesByName['storage'])];
                        }
                        if (!empty($attributeValuesByName['ram'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['ram'][$v % count($attributeValuesByName['ram'])];
                        }
                    } elseif ($catName === 'Groceries' || $catName === 'Beauty & Personal Care' || $catName === 'Health') {
                        if (!empty($attributeValuesByName['weight'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['weight'][$v % count($attributeValuesByName['weight'])];
                        } elseif (!empty($attributeValuesByName['capacity'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['capacity'][$v % count($attributeValuesByName['capacity'])];
                        }
                    } else {
                        if (!empty($attributeValuesByName['color'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['color'][$v % count($attributeValuesByName['color'])];
                        }
                        if (!empty($attributeValuesByName['material'])) {
                            $attachAttributeValueIds[] = $attributeValuesByName['material'][$v % count($attributeValuesByName['material'])];
                        }
                    }

                    if (empty($attachAttributeValueIds) && !empty($attributes)) {
                        $randomValue = AttributeValue::inRandomOrder()->first();
                        if ($randomValue) {
                            $attachAttributeValueIds[] = $randomValue->id;
                        }
                    }

                    if (!empty($attachAttributeValueIds)) {
                        $variant->attributeValues()->attach($attachAttributeValueIds);
                    }
                }
            }
        }

        $this->command->info("Successfully seeded 250 Bangladeshi products with galleries, variants, and attribute values!");
    }
}
