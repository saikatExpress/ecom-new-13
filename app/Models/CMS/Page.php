<?php

namespace App\Models\CMS;

use App\Models\BaseModel;
use App\Traits\HasSlug;

class Page extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];
}
