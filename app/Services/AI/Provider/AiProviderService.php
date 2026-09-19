<?php

namespace App\Services\AI\Provider;

use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;
use App\Models\AI\AiProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AiProviderService
{
    public function __construct(protected AiProvider $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size');
        $searchKey = $request->input('search_key');

        $results = $this->model
        ->when($searchKey, function($query, $searchKey){
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->paginate($paginateSize);

        return $results;
    }

    public function store($request)
    {
        return DB::transaction(function() use ($request) {
            $ai = new $this->model();

            $ai->name = Str::title($request->name);
            $ai->slug = Str::slug($request->name, '-');
            $ai->status = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $ai->img_path = FileUploadHelper::upload($request->file('image'), 'ai');
            }

            $ai->save();

            return $ai;
        });
    }

    public function show($id)
    {
        $ai = $this->model::find($id);

        if(!$ai){
            throw new CustomException("AI Not Found");
        }

        return $ai;
    }

    public function update($request, $id)
    {
        return DB::transaction(function() use ($request, $id) {
            $ai = $this->model::find($id);

            if(!$ai){
                throw new CustomException("AI Not Found");
            }

            $ai->name   = Str::title($request->name);
            $ai->slug   = Str::slug($request->name, '-');
            $ai->status = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $ai->img_path = FileUploadHelper::replace($request->file('image'), $ai->img_path, 'ai');
            }

            $ai->save();

            return $ai;
        });
    }

    public function destroy($id)
    {
        $ai = $this->model::find($id);

        if(!$ai){
            throw new CustomException("AI Not Found");
        }

        $ai->delete();

        return true;
    }
}
