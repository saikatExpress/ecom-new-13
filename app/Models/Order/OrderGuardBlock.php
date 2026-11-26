<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderGuardBlock extends Model
{
    protected $fillable = [
        'type',
        'value',
        'phone_number',
        'reason',
        'block_type',
        'source',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'phone_number' => 'encrypted',
        'expires_at'   => 'datetime',
        'is_active'    => 'boolean',
    ];
}
