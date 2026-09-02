<?php

namespace App\Models\Order;

use App\Traits\HasSlug;
use App\Models\BaseModel;

class Status extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];
}
