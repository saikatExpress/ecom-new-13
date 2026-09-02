<?php

namespace App\Services\CMS;

use App\Models\CMS\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;

class BannerService
{
    public function __construct(protected Banner $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $sectionId = $request->section_id;

        $banners = $this->model
        ->with([
            'section:id,name',
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->when($sectionId, function($query, $sectionId){
            $query->where('section_id', $sectionId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $banners;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $sectionId = $request->section_id;

        $banners = $this->model::onlyTrashed()
        ->with([
            'deletedBy:id,username'
        ])
        ->when($sectionId, function($query, $sectionId){
            $query->where('section_id', $sectionId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $banners;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $banner = new $this->model();

            $banner->name        = Str::title($request->name);
            $banner->section_id  = $request->section_id;
            $banner->link        = $request->link;
            $banner->device_type = $request->device_type;
            $banner->status      = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $banner->img_path = FileUploadHelper::upload($request->file('image'), 'banner');
            }

            $banner->save();

            return $banner;
        });
    }

    public function show($id)
    {
        $banner = $this->model::with('section')->find($id);

        if(!$banner){
            throw new CustomException("Banner not found");
        }

        return $banner;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $banner = $this->model::find($id);

            if(!$banner){
                throw new CustomException("Banner not found");
            }

            $banner->name        = Str::title($request->name);
            $banner->section_id  = $request->section_id;
            $banner->link        = $request->link;
            $banner->device_type = $request->device_type;
            $banner->status      = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $banner->img_path = FileUploadHelper::replace($request->file('image'),$banner->img_path, 'banner');
            }

            $banner->save();

            return $banner;
        });
    }

    public function destroy($id)
    {
        $banner = $this->model::find($id);

        if(!$banner){
            throw new CustomException("Banner not found");
        }

        $banner->delete();

        return true;
    }

    public function restore($id)
    {
        $banner = $this->model::onlyTrashed()->find($id);

        if(!$banner){
            throw new CustomException("Banner not found");
        }

        $banner->restore();

        return $banner;
    }

    public function permanentDelete($id)
    {
        $banner = $this->model::onlyTrashed()->find($id);

        if(!$banner){
            throw new CustomException("Banner not found");
        }

        FileUploadHelper::delete($banner->img_path);

        $banner->forceDelete();

        return true;
    }
}
