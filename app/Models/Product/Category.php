<?php

namespace App\Models\Product;

use App\Traits\HasSlug;
use BaseModel;

class Category extends BaseModel
{
    use HasSlug;

    // Relations
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
