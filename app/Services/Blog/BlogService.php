<?php

namespace App\Services\Blog;

use Illuminate\Support\Str;
use App\Models\Blog\BlogPost;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;

class BlogService
{
    public function __construct(protected BlogPost $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryIds  = $request->input('category_ids', []);
        $tagIds       = $request->input('tag_ids', []);

        $blogs = $this->model
        ->with([
            'category:id,name',
            'tags',
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->when($searchKey, function($query, $searchKey){
            $query->where('title', 'like', "%{$searchKey}%");
        })
        ->when($categoryIds, function($query, $categoryIds){
            $query->whereIn('category_id', $categoryIds);
        })
        ->when($tagIds, function($query, $tagIds){
            $query->whereHas('tags', function($query) use ($tagIds) {
                $query->whereIn('blog_tags.id', $tagIds);
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $blogs;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryIds  = $request->input('category_ids', []);

        $blogs = $this->model::onlyTrashed()
        ->with([
            'category:id,name',
            'deletedBy:id,username'
        ])
        ->when($searchKey, function($query, $searchKey){
            $query->where('title', 'like', "%{$searchKey}%");
        })
        ->when($categoryIds, function($query, $categoryIds){
            $query->whereIn('category_id', $categoryIds);
        })
        ->orderBy('deleted_at', 'desc')
        ->paginate($paginateSize);

        return $blogs;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request){
            $blog = new $this->model();

            $blog->title            = Str::title($request->title);
            $blog->slug             = Str::slug($request->title, '-');
            $blog->category_id      = $request->category_id;
            $blog->excerpt          = $request->excerpt;
            $blog->content          = $request->content;
            $blog->meta_title       = $request->meta_title;
            $blog->meta_keywords    = $request->meta_keywords;
            $blog->meta_description = $request->meta_description;
            $blog->status           = $request->status;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $blog->img_path = FileUploadHelper::upload($request->file('image'), 'blogs');
            }

            $blog->save();

            if ($request->has('tag_ids') && is_array($request->tag_ids)) {
                $blog->tags()->attach($request->tag_ids);
            }

            return $blog;
        });
    }

    public function show($id)
    {
        $blog = $this->model
        ->with([
            'category:id,name',
            'tags',
            'createdBy:id,username'
        ])
        ->find($id);

        if(!$blog){
            throw new CustomException("Blog not found");
        }

        return $blog;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $blog = $this->model::find($id);

            if(!$blog){
                throw new CustomException("Blog not found");
            }

            $blog->title            = Str::title($request->title);
            $blog->slug             = Str::slug($request->title, '-');
            $blog->category_id      = $request->category_id;
            $blog->excerpt          = $request->excerpt;
            $blog->content          = $request->content;
            $blog->meta_title       = $request->meta_title;
            $blog->meta_keywords    = $request->meta_keywords;
            $blog->meta_description = $request->meta_description;
            $blog->status           = $request->status;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $blog->img_path = FileUploadHelper::replace($request->file('image'),$blog->img_path, 'blogs');
            }

            $blog->save();

            if ($request->has('tag_ids') && is_array($request->tag_ids)) {
                $blog->tags()->sync($request->tag_ids);
            }

            return $blog->load(['category', 'tags']);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $blog = $this->model::find($id);

            if(!$blog){
                throw new CustomException("Blog not found");
            }

            $blog->delete();

            return true;
        });
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {

            $blog = $this->model::onlyTrashed()->find($id);

            if (!$blog) {
                throw new CustomException('Blog post not found');
            }

            $blog->restore();

            return $blog;
        });
    }

    public function permanentDelete($id)
    {
        try {
            return DB::transaction(function () use ($id) {

                $blog = $this->model::onlyTrashed()->find($id);

                if (!$blog) {
                    throw new CustomException('Deleted blog post not found');
                }

                $blog->tags()->detach();

                $blog->forceDelete();

                return true;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }
}
