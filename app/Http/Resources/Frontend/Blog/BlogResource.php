<?php

namespace App\Http\Resources\Frontend\Blog;

use Illuminate\Http\Request;
use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id'   => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),

            'title'   => $this->title,
            'slug'    => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'image'   => FileUrlHelper::url($this->img_path),

            'meta_title'       => $this->meta_title,
            'meta_keywords'    => $this->meta_keywords,
            'meta_description' => $this->meta_description,

            'status'      => $this->status,
            'views_count' => $this->views_count,

            'tags' => $this->whenLoaded('tags', function () {
                return $this->tags->map(function ($tag) {
                    return [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        'slug' => $tag->slug,
                    ];
                });
            }),
            'created_at' => $this->created_at,
        ];
    }
}
