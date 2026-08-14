<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $guarded = ['id'];

    // Relation
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class);
    }
}
