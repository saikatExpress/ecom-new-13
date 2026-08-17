<?php

namespace App\Services\User;

use Illuminate\Support\Str;
use App\Models\UserCategory;
use App\Exceptions\CustomException;

class UserCategoryService
{
    public function __construct(protected UserCategory $model){}

    public function index()
    {
        $categories = $this->model::all();

        return $categories;
    }

    public function store($request)
    {
        $category = new $this->model();

        $category->name   = Str::title($request->name);
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        return $category;
    }

    public function show($id)
    {
        $category = $this->model::find($id);

        if(!$category){
            throw new CustomException("Category not found");
        }

        return $category;
    }

    public function update($request, $id)
    {
        $category = $this->model::find($id);

        if(!$category){
            throw new CustomException("Category not found");
        }

        $category->name   = Str::title($request->name);
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        return $category;
    }

    public function destroy($id)
    {
        $category = $this->model::find($id);

        if(!$category){
            throw new CustomException("Category not found");
        }

        $category->delete();

        return true;
    }
}
