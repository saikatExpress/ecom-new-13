<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use App\Traits\HasSlug;

class Brand extends BaseModel
{
    use HasSlug;

    // Relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
