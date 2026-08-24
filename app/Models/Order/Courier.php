<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Traits\HasSlug;

class Courier extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'is_default' => 'boolean'
    ];
}
