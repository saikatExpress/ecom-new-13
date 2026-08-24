<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use App\Models\Order\Courier;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;

class CourierService
{
    public function __construct(protected Courier $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $couriers = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $couriers;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $couriers = $this->model::onlyTrashed()
        ->with([
            'deletedBy:id,username',
        ])
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

        return $couriers;
    }

    public function list()
    {
        $couriers = $this->model::select('id', 'name', 'is_default')->where('status', 'active')->get();

        return $couriers;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $courier = new $this->model();

            $courier->name       = Str::title($request->name);
            $courier->is_default = $request->is_default;
            $courier->status     = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $courier->img_path = FileUploadHelper::upload($request->file('image'), 'couriers');
            }

            $courier->save();

            return $courier;
        });
    }

    public function show($id)
    {
        $courier = $this->model::find($id);

        if(!$courier){
            throw new CustomException("Courier not found");
        }

        return $courier;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $courier = $this->model::find($id);

            if(!$courier){
                throw new CustomException("Courier not found");
            }

            $courier->name       = Str::title($request->name);
            $courier->is_default = $request->is_default;
            $courier->status     = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $courier->img_path = FileUploadHelper::upload($request->file('image'), 'couriers');
            }

            $courier->save();

            return $courier;
        });
    }

    public function destroy($id)
    {
        $courier = $this->model::find($id);

        if(!$courier){
            throw new CustomException("Courier not found");
        }

        $courier->delete();

        return true;
    }

    public function restore($id)
    {
        $courier = $this->model::onlyTrashed()->find($id);

        if(!$courier){
            throw new CustomException("Courier not found");
        }

        $courier->restore();

        return $courier;
    }

    public function permanentDelete($id)
    {
        $courier = $this->model::find($id);

        if(!$courier){
            throw new CustomException("Courier not found");
        }

        FileUploadHelper::delete($courier->img_path);

        $courier->forceDelete();

        return true;
    }
}
