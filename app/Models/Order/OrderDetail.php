<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'variant_options' => 'array',
        ];
    }
}
