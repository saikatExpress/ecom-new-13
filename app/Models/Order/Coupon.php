<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Product\Product;
use App\Models\Product\Category;

class Coupon extends BaseModel
{
    protected $guarded = ['id'];

    // Relations
    public function products()
    {
        return $this->belongsToMany(Product::class,'coupon_products');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'coupon_categories');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class,'coupon_id');
    }
}
