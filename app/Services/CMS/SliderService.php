<?php

namespace App\Services\CMS;

use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;
use App\Models\CMS\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SliderService
{
    public function __construct(protected Slider $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $sliders = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->paginate($paginateSize);

        return $sliders;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $sliders = $this->model::onlyTrashed()
        ->with([
            'deletedBy:id,username'
        ])
        ->paginate($paginateSize);

        return $sliders;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $slider = new $this->model();

            $slider->name        = Str::title($request->name);
            $slider->link        = $request->link;
            $slider->device_type = $request->device_type;
            $slider->status      = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $slider->img_path = FileUploadHelper::upload($request->file('image'), 'sliders');
            }

            $slider->save();

            return $slider;
        });
    }

    public function show($id)
    {
        $slider = $this->model::find($id);

        if(!$slider){
            throw new CustomException("Slider not found");
        }

        return $slider;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $slider = $this->model::find($id);

            if(!$slider){
                throw new CustomException('Slider not found');
            }

            $slider->name        = Str::title($request->name);
            $slider->link        = $request->link;
            $slider->device_type = $request->device_type;
            $slider->status      = $request->status;

            if($request->hasFile('image')){
                $slider->img_path = FileUploadHelper::replace($request->file('image'), $slider->img_path, 'sliders');
            }

            $slider->save();

            return $slider;
        });
    }

    public function destroy($id)
    {
        $slider = $this->model::find($id);

        if(!$slider){
            throw new CustomException("Slider not found");
        }

        $slider->delete();

        return true;
    }

    public function restore($id)
    {
        $slider = $this->model::onlyTrashed()->find($id);

        if(!$slider){
            throw new CustomException("Slider not found");
        }

        $slider->restore();

        return $slider;
    }

    public function permanentDelete($id)
    {
        $slider = $this->model::onlyTrashed()->find($id);

        if(!$slider){
            throw new CustomException("Slider not found");
        }

        FileUploadHelper::delete($slider->img_path);

        $slider->forceDelete();

        return true;
    }
}
