<?php

namespace App\Models\Blog;

use App\Models\BaseModel;

class BlogPost extends BaseModel
{
    protected $guarded = ['id'];

    // Relations
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class,'blog_post_tag','blog_post_id','blog_tag_id');
    }
}
