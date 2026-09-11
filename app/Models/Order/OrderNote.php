<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderNote extends BaseModel
{
    protected $guarded = ['id'];

    // Relations
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
