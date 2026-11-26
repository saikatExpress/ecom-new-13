<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderGuardOrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'phone_hash',
        'user_token',
        'ip_address',
        'user_agent',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
