<?php

namespace App\Helpers\Coupon;

use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Models\Order\Coupon;
use App\Models\Product\Product;
use Illuminate\Support\Collection;

class CouponHelper
{
    public static function validateCoupon(Coupon $coupon): void
    {
        if ($coupon->status !== 'active') {
            throw new CustomException('This coupon is inactive.');
        }

        if ($coupon->starts_at && now()->lt($coupon->starts_at)) {
            throw new CustomException('This coupon is not available yet.');
        }

        if ($coupon->expires_at && now()->gte($coupon->expires_at)) {
            throw new CustomException('This coupon has expired.');
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            throw new CustomException('This coupon usage limit has been reached.');
        }
    }

    public static function calculateCart(array $items): array
    {
        $productIds = collect($items)->pluck('product_id')->map(fn ($id) => (int) $id)->unique()->values();

        $products = Product::query()
        ->whereIn('id', $productIds)
        ->where('status', StatusEnum::ACTIVE->value)
        ->get([
            'id',
            'name',
            'category_id',
            'sub_category_id',
            'sell_price',
            'offer_price',
        ])
        ->keyBy('id');

        if ($products->count() !== $productIds->count()) {
            throw new CustomException('Some products in your cart are unavailable.');
        }

        $cartItems = [];
        $cartSubtotal = 0;

        foreach ($items as $item) {

            $product = $products->get((int) $item['product_id']);

            $unitPrice = (float) (
                $product->offer_price > 0 ? $product->offer_price : $product->sell_price
            );

            $quantity = (int) $item['quantity'];

            $lineTotal = round($unitPrice * $quantity,2);

            $cartSubtotal += $lineTotal;

            $cartItems[] = [
                'product_id' => (int) $product->id,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        return [
            'products' => $products->values(),

            'items' => collect($cartItems),

            'cart_subtotal' => round($cartSubtotal, 2),
        ];
    }

    public static function getEligibleProducts(Coupon $coupon,Collection $cartProductIds,Collection $cartProducts): Collection {

        switch ($coupon->apply_scope) {

            case 'all_products':
                return $cartProductIds;
            case 'selected_products':
                $couponProductIds = $coupon->products->pluck('id')->map(fn ($id) => (int) $id);

                return $cartProductIds->intersect($couponProductIds)->values();
            case 'selected_categories':

                $couponCategoryIds = $coupon->categories->pluck('id')->map(fn ($id) => (int) $id)->all();

                return $cartProducts
                ->filter(function ($product) use ($couponCategoryIds) {

                    $categoryId = (int) $product->category_id;

                    $subCategoryId = $product->sub_category_id ? (int) $product->sub_category_id : null;

                    return in_array($categoryId,$couponCategoryIds,true) || ($subCategoryId !== null && in_array($subCategoryId,$couponCategoryIds,true));
                })
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->values();
            default:
                throw new CustomException('Invalid coupon application scope.');
        }
    }

    public static function calculateDiscount(Coupon $coupon,float $eligibleSubtotal): float
    {

        $discountValue = (float) $coupon->discount_value;

        if ($coupon->discount_type === 'fixed') {
            $discount = $discountValue;
        } elseif ($coupon->discount_type === 'percentage') {
            $discount = ($eligibleSubtotal * $discountValue) / 100;
        } else {
            throw new CustomException('Invalid coupon discount type.');
        }

        if ($coupon->max_discount_amount !== null) {
            $discount = min($discount,(float) $coupon->max_discount_amount);
        }

        return round(min($discount, $eligibleSubtotal),2);
    }
}
