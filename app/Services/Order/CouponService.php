<?php

namespace App\Services\Order;

use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Helpers\Coupon\CouponHelper;
use App\Models\Order\Coupon;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponService
{
    public function __construct(protected Coupon $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $searchKey    = $request->filled('search_key');
        $discountType = $request->filled('discount_type');
        $applyScope   = $request->filled('apply_scope');
        $status       = $request->filled('status');
        $dateFrom     = $request->filled('date_from');
        $dateTo       = $request->filled('date_to');

        $coupons = $this->model
        ->query()
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
            'products:id,name,sell_price',
            'categories:id,name',
        ])

        ->when($searchKey, function ($query, $searchKey) {
            $query->where('code', 'like', '%' . $searchKey . '%');
        })

        ->when($discountType, function ($query, $discountType) {
            $query->where('discount_type', $discountType);
        })

        ->when($applyScope, function ($query, $applyScope) {
            $query->where('apply_scope', $applyScope);
        })

        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })

        ->when($dateFrom, function ($query, $dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        })

        ->when($dateTo, function ($query, $dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        })

        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $coupons;
    }

    public function list()
    {
        $now = now();

        $coupons = $this->model
        ->select('id', 'code')
        ->where('status', StatusEnum::ACTIVE)
        ->where(function ($query) use ($now) {
            $query->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function ($query) use ($now) {
            $query->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
        })
        ->get();

        return $coupons;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $searchKey    = $request->filled('search_key');
        $discountType = $request->filled('discount_type');
        $applyScope   = $request->filled('apply_scope');
        $status       = $request->filled('status');

        $coupons = $this->model::onlyTrashed()
        ->with([
            'deletedBy:id,username'
        ])

        ->when($searchKey, function ($query, $searchKey) {
            $query->where('code', 'like', '%' . $searchKey . '%');
        })

        ->when($discountType, function ($query, $discountType) {
            $query->where('discount_type', $discountType);
        })

        ->when($applyScope, function ($query, $applyScope) {
            $query->where('apply_scope', $applyScope);
        })

        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $coupons;
    }

    public function apply(array $data): array
    {
        $coupon = $this->model
        ->newQuery()
        ->with([
            'products:id',
            'categories:id',
        ])
        ->where('code', Str::upper(trim($data['code'])))
        ->first();

        if (!$coupon) {
            throw new CustomException('Invalid coupon code.');
        }

        CouponHelper::validateCoupon($coupon);

        $cart = CouponHelper::calculateCart($data['items']);

        $cartSubtotal = $cart['cart_subtotal'];

        $frontendCartAmount = round((float) $data['cart_amount'], 2);

        if (abs($cartSubtotal - $frontendCartAmount) > 0.01) {
            throw new CustomException('Cart amount has changed. Please refresh your cart.');
        }

        $cartProductIds = collect($cart['items'])->pluck('product_id')->unique()->values();

        $eligibleProductIds = CouponHelper::getEligibleProducts($coupon,$cartProductIds,$cart['products']);

        $excludedProductIds = $cartProductIds->diff($eligibleProductIds)->values();

        $eligibleSubtotal = round(
            collect($cart['items'])
                ->filter(fn ($item) => $eligibleProductIds->contains($item['product_id']))
                ->sum('line_total'),
            2
        );

        $minimumOrderAmount = (float) $coupon->min_order_amount;

        $minimumOrderMet = $eligibleProductIds->isNotEmpty() && $eligibleSubtotal >= $minimumOrderAmount;

        $minimumOrderShortfall = max(0, round($minimumOrderAmount - $eligibleSubtotal, 2));

        $discountAmount = $minimumOrderMet ? CouponHelper::calculateDiscount($coupon, $eligibleSubtotal) : 0;

        if ($eligibleProductIds->isEmpty()) {
            $message = 'This coupon is not applicable to the products in your cart.';
        } elseif (!$minimumOrderMet) {
            $message = 'Add more eligible products worth ' . number_format($minimumOrderShortfall, 2) . ' to apply this coupon.';
        } elseif ($excludedProductIds->isNotEmpty()) {
            $message = 'Coupon applied to eligible products only.';
        } else {
            $message = 'Coupon applied successfully.';
        }

        return [
            'message'       => $message,
            'coupon_valid'  => true,
            'is_applicable' => $minimumOrderMet,
            'coupon'        => [
                'id'                  => $coupon->id,
                'code'                => $coupon->code,
                'discount_type'       => $coupon->discount_type,
                'discount_value'      => (float) $coupon->discount_value,
                'apply_scope'         => $coupon->apply_scope,
                'min_order_amount'    => $minimumOrderAmount,
                'max_discount_amount' => $coupon->max_discount_amount !== null ? (float) $coupon->max_discount_amount : null,
            ],
            'cart_subtotal'           => $cartSubtotal,
            'eligible_subtotal'       => $eligibleSubtotal,
            'minimum_order_met'       => $minimumOrderMet,
            'minimum_order_shortfall' => $minimumOrderShortfall,
            'discount_amount'         => $discountAmount,
            'amount_after_discount'   => round($cartSubtotal - $discountAmount,2),
            'eligible_product_ids'    => $eligibleProductIds->all(),
            'excluded_product_ids'    => $excludedProductIds->all(),
        ];
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $coupon = $this->model->create([
                'code'                => $request->code,
                'discount_type'       => $request->discount_type,
                'discount_value'      => $request->discount_value,
                'apply_scope'         => $request->apply_scope,
                'min_order_amount'    => $request->min_order_amount ?? 0,
                'max_discount_amount' => $request->max_discount_amount,
                'usage_limit'         => $request->usage_limit,
                'per_phone_limit'     => $request->per_phone_limit,
                'starts_at'           => $request->starts_at,
                'expires_at'          => $request->expires_at,
                'status'              => $request->status,
            ]);

            if ($request->apply_scope === 'selected_products') {
                $coupon->products()->sync($request->product_ids);
            }

            if ($request->apply_scope === 'selected_categories') {
                $coupon->categories()->sync($request->category_ids);

                $productIds = Product::query()->whereIn('category_id', $request->category_ids)->pluck('id')->unique()->values()->toArray();

                $coupon->products()->sync($productIds);
            }

            return $coupon;
        });
    }

    public function show($id)
    {
        $coupon = $this->model
        ->with([
            'products:id,name,img_path,sell_price',
            'categories:id,name',
        ])
        ->find($id);

        if (!$coupon) {
            throw new CustomException("Coupon not found");
        }

        return $coupon;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $coupon = $this->model::find($id);

            if (!$coupon) {
                throw new CustomException('Coupon not found');
            }

            $coupon->update([
                'code'                => $request->code,
                'discount_type'       => $request->discount_type,
                'discount_value'      => $request->discount_value,
                'apply_scope'         => $request->apply_scope,
                'min_order_amount'    => $request->min_order_amount ?? 0,
                'max_discount_amount' => $request->max_discount_amount,
                'usage_limit'         => $request->usage_limit,
                'per_phone_limit'     => $request->per_phone_limit,
                'starts_at'           => $request->starts_at,
                'expires_at'          => $request->expires_at,
                'status'              => $request->status,
            ]);


            if ($request->apply_scope === 'all_products') {
                $coupon->products()->sync([]);

                $coupon->categories()->sync([]);
            }elseif ($request->apply_scope === 'selected_products') {
                $coupon->products()->sync($request->product_ids);

                $coupon->categories()->sync([]);
            }elseif ($request->apply_scope === 'selected_categories') {

                $coupon->categories()->sync($request->category_ids);

                $productIds = Product::query()->whereIn('category_id', $request->category_ids)->pluck('id')->unique()->values()->toArray();

                $coupon->products()->sync($productIds);
            }

            return $coupon;
        });
    }

    public function destroy($id)
    {
        $coupon = $this->model::find($id);

        if (!$coupon) {
            throw new CustomException('Coupon not found');
        }

        $coupon->delete();

        return true;
    }

    public function restore($id)
    {
        $coupon = $this->model->onlyTrashed()->find($id);

        if (!$coupon) {
            throw new CustomException('Coupon not found');
        }

        $coupon->restore();

        return $coupon;
    }

    public function permanentDelete($id)
    {
        $coupon = $this->model->withTrashed()->find($id);

        if (!$coupon) {
            throw new CustomException('Coupon not found');
        }

        $coupon->forceDelete();

        return true;
    }
}
