<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $guarded = ['id'];

    // Relations
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'district_id');
    }
}
