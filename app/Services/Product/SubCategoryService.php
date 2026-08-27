<?php

namespace App\Services\Product;

use Exception;
use Illuminate\Support\Str;
use App\Exceptions\CustomException;
use App\Models\Product\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Helpers\File\FileUploadHelper;

class SubCategoryService
{
    public function __construct(protected SubCategory $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryId   = $request->input('category_id');

        $subCategories = $this->model
        ->with(
            'category:id,name',
            'createdBy:id,username',
            'updatedBy:id,username',
        )
        ->when($searchKey, function($query, $searchKey){
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->when($categoryId, function($query,$categoryId){
            $query->where('category_id', $categoryId);
        })
        ->orderByDesc('created_at')
        ->paginate($paginateSize);

        return $subCategories;
    }

    public function list($request)
    {
        $categoryId = $request->input('category_id');

        $subCategories = $this->model
        ->select('id', 'name', 'slug')
        ->when($categoryId, function($query, $categoryId){
            $query->where('category_id', $categoryId);
        })
        ->where('status', 'active')
        ->get();

        return $subCategories;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryId   = $request->input('category_id');

        $results = $this->model::onlyTrashed()
        ->with(
            'category:id,name',
            'deletedBy:id,username',
        )
        ->when($searchKey, function($query, $searchKey){
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->when($categoryId, function($query,$categoryId){
            $query->where('category_id', $categoryId);
        })
        ->latest()
        ->paginate($paginateSize);

        return $results;
    }

    public function store($request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $subCategory = new $this->model();

                $subCategory->category_id = $request->category_id;
                $subCategory->name        = Str::title($request->name);
                $subCategory->status      = $request->status;

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $subCategory->img_path = FileUploadHelper::upload($request->file('image'),'subCategories');
                }

                $subCategory->save();

                return $subCategory;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $subCategory = $this->model
            ->with(
                'category:id,name',
                'createdBy:id,username',
                'updatedBy:id,username',
            )
            ->find($id);

            if(!$subCategory){
                throw new CustomException("Sub Category Not Found");
            }

            return $subCategory;
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $subCategory = $this->model::find($id);

                if(!$subCategory){
                    throw new CustomException("Sub Category not found");
                }

                $subCategory->category_id = $request->category_id;
                $subCategory->name = Str::title($request->name);
                $subCategory->status = $request->status;

                if ($request->hasFile('image')) {
                    $subCategory->img_path = FileUploadHelper::replace($request->file('image'),$subCategory->img_path,'subCategories');
                }

                $subCategory->save();

                return $subCategory->fresh();
            });

        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function restore($id)
    {
        $subCategory = $this->model::onlyTrashed()->find($id);

        if (!$subCategory) {
            throw new CustomException("Sub Category Not Found");
        }

        $subCategory->restore();

        return $subCategory;
    }

    public function destroy($id)
    {
        try {
            $subCategory = $this->model::find($id);

            if(!$subCategory){
                throw new CustomException("Sub Category Not Found");
            }

            return $subCategory->delete();
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function forceDelete($id)
    {
        $subCategory = $this->model::onlyTrashed()->find($id);

        if (!$subCategory) {
            throw new CustomException("Sub Category Not Found");
        }

        FileUploadHelper::delete($subCategory->img_path);

        $subCategory->forceDelete();

        return true;
    }
}
