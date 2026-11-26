<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderGuardLog extends Model
{
    protected $fillable = [
        'order_id',
        'phone_hash',
        'user_token',
        'ip_address',
        'action',
        'reason',
        'violation_count',
    ];

    protected $casts = [
        'violation_count' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
