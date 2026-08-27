<?php

namespace App\Services\Product;

use Exception;
use Illuminate\Support\Str;
use App\Models\Product\Brand;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;

class BrandService
{
    public function __construct(protected Brand $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey = $request->input('search_key');

        $brands = $this->model
        ->with(
            'createdBy:id,username',
            'updatedBy:id,username',
        )
        ->when($searchKey, function ($query, $searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->orderByDesc('created_at')
        ->paginate($paginateSize);

        return $brands;
    }

    public function list()
    {
        $brands = $this->model->select('id', 'name', 'slug')->where('status', 'active')->get();

        return $brands;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $results = $this->model
        ->with('deletedBy:id,username')
        ->onlyTrashed()
        ->when($request->filled('search_key'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search_key}%");
        })
        ->latest()
        ->paginate($paginateSize);

        return $results;
    }

    public function store($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $brand = new $this->model();

                $brand->name   = Str::title($request->name);
                $brand->status = $request->status;

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $brand->img_path = FileUploadHelper::upload($request->file('image'),'brands');
                }

                $brand->save();

                return $brand;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $brand = $this->model
            ->with(
                'createdBy:id,username',
                'updatedBy:id,username',
            )
            ->find($id);

            if(!$brand){
                throw new CustomException("Brand Not Found");
            }

            return $brand;
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $brand = $this->model::find($id);

                if(!$brand){
                    throw new CustomException("Brand not found");
                }

                $brand->name = Str::title($request->name);
                $brand->status = $request->status;

                if ($request->hasFile('image')) {
                    $brand->img_path = FileUploadHelper::replace($request->file('image'),$brand->img_path,'brands');
                }

                $brand->save();

                return $brand;
            });

        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function restore($id)
    {
        $brand = $this->model::onlyTrashed()->find($id);

        if (!$brand) {
            throw new CustomException("Brand Not Found");
        }

        $brand->restore();

        return $brand;
    }

    public function destroy($id)
    {
        try {
            $brand = $this->model::find($id);

            if(!$brand){
                throw new CustomException("Brand Not Found");
            }

            return $brand->delete();
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function forceDelete($id)
    {
        $brand = $this->model::onlyTrashed()->find($id);

        if (!$brand) {
            throw new CustomException("Brand Not Found");
        }

        FileUploadHelper::delete($brand->img_path);

        $brand->forceDelete();

        return true;
    }
}
