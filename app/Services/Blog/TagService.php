<?php

namespace App\Services\Blog;

use Illuminate\Support\Str;
use App\Models\Blog\BlogTag;
use App\Exceptions\CustomException;

class TagService
{
    public function __construct(protected BlogTag $model){}

    public function index()
    {
        $tags = $this->model::all();

        return $tags;
    }

    public function list()
    {
        $tags = $this->model::select('id', 'name', 'slug')->get();

        return $tags;
    }

    public function store($request)
    {
        $tag = new $this->model();

        $tag->name   = Str::title($request->name);
        $tag->slug   = Str::slug($request->name, '-');
        $tag->status = $request->status;
        $tag->save();

        return $tag;
    }

    public function show($id)
    {
        $tag = $this->model::find($id);

        if(!$tag){
            throw new CustomException("Tag not found");
        }

        return $tag;
    }

    public function update($request, $id)
    {
        $tag = $this->model::find($id);

        if(!$tag){
            throw new CustomException("Tag not found");
        }

        $tag->name   = Str::title($request->name);
        $tag->slug   = Str::slug($request->name, '-');
        $tag->status = $request->status;
        $tag->save();

        return $tag;
    }

    public function destroy($id)
    {
        $tag = $this->model::find($id);

        if(!$tag){
            throw new CustomException("Tag not found");
        }

        $tag->delete();

        return true;
    }
}
