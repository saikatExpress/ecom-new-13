<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $guarded = ['id'];

    // Relation
    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }
}
