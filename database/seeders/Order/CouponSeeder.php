<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use App\Models\Order\Coupon;
use App\Enums\DiscountTypeEnum;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use App\Models\Product\Category;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code'                => 'WELCOME200',
            'discount_type'       => DiscountTypeEnum::FIXED,
            'discount_value'      => 200,
            'apply_scope'         => 'all_products',
            'min_order_amount'    => 1000,
            'max_discount_amount' => null,
            'usage_limit'         => 500,
            'per_phone_limit'     => 1,
            'used_count'          => 0,
            'starts_at'           => now(),
            'expires_at'          => now()->addDays(30),
            'status'              => StatusEnum::ACTIVE,
        ]);

        Coupon::create([
            'code'                => 'SAVE10',
            'discount_type'       => DiscountTypeEnum::PERCENTAGE,
            'discount_value'      => 10,
            'apply_scope'         => 'all_products',
            'min_order_amount'    => 1500,
            'max_discount_amount' => 500,
            'usage_limit'         => 1000,
            'per_phone_limit'     => 2,
            'used_count'          => 0,
            'starts_at'           => now(),
            'expires_at'          => now()->addDays(15),
            'status'              => StatusEnum::ACTIVE,
        ]);

        $flashCoupon = Coupon::create([
            'code'                => 'FLASH15',
            'discount_type'       => DiscountTypeEnum::PERCENTAGE,
            'discount_value'      => 15,
            'apply_scope'         => 'selected_products',
            'min_order_amount'    => 2000,
            'max_discount_amount' => 700,
            'usage_limit'         => 200,
            'per_phone_limit'     => 1,
            'used_count'          => 0,
            'starts_at'           => now(),
            'expires_at'          => now()->addDays(7),
            'status'              => StatusEnum::ACTIVE,
        ]);

        $flashCoupon->products()->sync(
            Product::query()->whereIn('id', range(1, 10))->pluck('id')->toArray()
        );

        $fashionCoupon = Coupon::create([
            'code'                => 'FASHION300',
            'discount_type'       => DiscountTypeEnum::FIXED,
            'discount_value'      => 300,
            'apply_scope'         => 'selected_categories',
            'min_order_amount'    => 2500,
            'max_discount_amount' => null,
            'usage_limit'         => 300,
            'per_phone_limit'     => 1,
            'used_count'          => 0,
            'starts_at'           => now(),
            'expires_at'          => now()->addDays(20),
            'status'              => StatusEnum::ACTIVE,
        ]);

        $categoryIds = Category::query()->whereIn('id', [1, 2])->pluck('id')->toArray();

        $fashionCoupon->categories()->sync($categoryIds);

        $productIds = Product::query()->whereIn('category_id', $categoryIds)->pluck('id')->unique()->toArray();

        $fashionCoupon->products()->sync($productIds);

        $bigDealCoupon = Coupon::create([
            'code'                => 'BIGDEAL20',
            'discount_type'       => DiscountTypeEnum::PERCENTAGE,
            'discount_value'      => 20,
            'apply_scope'         => 'selected_products',
            'min_order_amount'    => 5000,
            'max_discount_amount' => 1000,
            'usage_limit'         => null,
            'per_phone_limit'     => null,
            'used_count'          => 0,
            'starts_at'           => now(),
            'expires_at'          => now()->addDays(60),
            'status'              => StatusEnum::ACTIVE,
        ]);

        $bigDealCoupon->products()->sync(
            Product::query()->whereIn('id', range(51, 100))->pluck('id')->toArray()
        );
    }
}
