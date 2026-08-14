<?php

namespace App\Models\CMS;

use App\Models\BaseModel;
use App\Traits\HasSlug;

class Slider extends BaseModel
{
    use HasSlug;

    protected $guarded = ['id'];
}
