<?php

namespace App\Models\Product;

use App\Traits\HasSlug;
use App\Models\BaseModel;

class Category extends BaseModel
{
    use HasSlug;

    // Relation
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
