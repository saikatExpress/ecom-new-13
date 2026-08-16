<?php

namespace App\Models\CMS;

use App\Traits\HasSlug;
use App\Models\BaseModel;

class Banner extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];

    // Relation
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
