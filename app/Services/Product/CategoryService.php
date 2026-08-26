<?php

namespace App\Services\Product;

use Exception;
use Illuminate\Support\Str;
use App\Models\Product\Category;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;

class CategoryService
{
    public function __construct(protected Category $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey = $request->input('search_key');

        $categories = $this->model
        ->with(
            'createdBy:id,username',
            'updatedBy:id,username',
        )
        ->when($searchKey, function($query, $searchKey){
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->orderByDesc('created_at')
        ->paginate($paginateSize);

        return $categories;
    }

    public function list()
    {
        $categories = $this->model->select('id', 'name', 'slug')->where('status', 'active')->get();

        return $categories;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $results = $this->model
        ->with(
            'deletedBy:id,username',
        )
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

                $category = new $this->model();

                $category->name     = Str::title($request->name);
                $category->position = $request->position;
                $category->status   = $request->status;

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $category->img_path = FileUploadHelper::upload($request->file('image'),'categories');
                }

                $category->save();

                return $category->fresh();
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $category = $this->model
            ->with(
                'createdBy:id,username',
                'updatedBy:id,username',
            )
            ->find($id);

            if(!$category){
                throw new CustomException("Brand Not Found");
            }

            return $category;
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $category = $this->model::find($id);

                if(!$category){
                    throw new CustomException("Category not found");
                }

                $category->name     = Str::title($request->name);
                $category->position = $request->position;
                $category->status   = $request->status;

                if ($request->hasFile('image')) {
                    $category->img_path = FileUploadHelper::replace($request->file('image'),$category->img_path,'brands');
                }

                $category->save();

                return $category->fresh();
            });

        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function reorder($request)
    {
        return DB::transaction(function () use ($request) {

            foreach ($request->categories as $category) {
                $this->model::where('id', $category['id'])->update(['position' => $category['position']]);
            }

            return true;
        });
    }

    public function restore($id)
    {
        $category = $this->model::onlyTrashed()->find($id);

        if (!$category) {
            throw new CustomException("Category Not Found");
        }

        $category->restore();

        return $category;
    }

    public function destroy($id)
    {
        try {
            $category = $this->model::find($id);

            if(!$category){
                throw new CustomException("Category Not Found");
            }

            return $category->delete();
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function forceDelete($id)
    {
        $category = $this->model::onlyTrashed()->find($id);

        if (!$category) {
            throw new CustomException("Category Not Found");
        }

        FileUploadHelper::delete($category->img_path);

        $category->forceDelete();

        return true;
    }
}
