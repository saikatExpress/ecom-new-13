<?php

namespace App\Models\Product;

use App\Traits\HasSlug;
use App\Models\BaseModel;

class Category extends BaseModel
{
    use HasSlug;

    // Relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
