<?php

namespace App\Models\Order;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $guarded = ['id'];

    // Relations
    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
