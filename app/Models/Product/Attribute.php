<?php

namespace App\Models\Product;

use App\Traits\HasSlug;
use App\Models\BaseModel;

class Attribute extends BaseModel
{
    use HasSlug;

    // Relation
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
