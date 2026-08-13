<?php

namespace App\Services\Blog;

use Illuminate\Support\Str;
use App\Models\Blog\BlogCategory;
use App\Exceptions\CustomException;

class BlogCategoryService
{
    public function __construct(protected BlogCategory $model){}

    public function index()
    {
        $results = $this->model::all();

        return $results;
    }

    public function list()
    {
        $results = $this->model->select('id', 'name', 'slug')->get();

        return $results;
    }

    public function store($request)
    {
        $blogCategory = new $this->model();

        $blogCategory->name        = Str::title($request->name);
        $blogCategory->slug        = Str::slug($request->name, '-');
        $blogCategory->description = $request->description;
        $blogCategory->status      = $request->status;
        $blogCategory->save();

        return $blogCategory;
    }

    public function show($id)
    {
        $blogCategory = $this->model::find($id);

        if(!$blogCategory){
            throw new CustomException("Blog Category not found");
        }

        return $blogCategory;
    }

    public function update($request, $id)
    {
        $blogCategory = $this->model::find($id);

        if(!$blogCategory){
            throw new CustomException("Blog Category not found");
        }

        $blogCategory->name        = Str::title($request->name);
        $blogCategory->slug        = Str::slug($request->name, '-');
        $blogCategory->description = $request->description;
        $blogCategory->status      = $request->status;
        $blogCategory->save();

        return $blogCategory;
    }

    public function destroy($id)
    {
        $blogCategory = $this->model::find($id);

        if(!$blogCategory){
            throw new CustomException("Blog Category not found");
        }

        $blogCategory->delete();

        return true;
    }
}
