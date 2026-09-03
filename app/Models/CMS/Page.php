<?php

namespace App\Models\CMS;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSlug;

    protected $guarded = ['id'];
}
