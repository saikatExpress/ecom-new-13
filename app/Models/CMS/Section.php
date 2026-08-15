<?php

namespace App\Models\CMS;

use App\Models\BaseModel;
use App\Traits\HasSlug;
use App\Models\Product\Product;

class Section extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];

    // Relations
    public function products()
    {
        return $this->belongsToMany(Product::class,'section_products','section_id','product_id');
    }
}
