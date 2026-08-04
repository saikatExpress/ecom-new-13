<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends BaseModel
{
    use HasSlug;

    // Relation
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
