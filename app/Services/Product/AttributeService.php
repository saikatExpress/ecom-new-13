<?php

namespace App\Services\Product;

use App\Exceptions\CustomException;
use App\Models\Product\Attribute;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeService
{
    public function __construct(protected Attribute $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey = $request->input('search_key');

        $attributes = $this->model
        ->with(
            'createdBy:id,username',
            'updatedBy:id,username',
        )
        ->when($searchKey, function ($query, $searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->orderByDesc('created_at')
        ->paginate($paginateSize);

        return $attributes;
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
                $attribute = new $this->model();

                $attribute->name = Str::title($request->name);

                $attribute->save();

                return $attribute;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $attribute = $this->model
            ->with(
                'createdBy:id,username',
                'updatedBy:id,username',
            )
            ->find($id);

            if(!$attribute){
                throw new CustomException("Brand Not Found");
            }

            return $attribute;
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $attribute = $this->model::find($id);

                if(!$attribute){
                    throw new CustomException("Attribute not found");
                }

                $attribute->name = Str::title($request->name);

                $attribute->save();

                return $attribute;
            });

        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function restore($id)
    {
        $attribute = $this->model::onlyTrashed()->find($id);

        if (!$attribute) {
            throw new CustomException("Attribute Not Found");
        }

        $attribute->restore();

        return $attribute;
    }

    public function destroy($id)
    {
        try {
            $attribute = $this->model::find($id);

            if(!$attribute){
                throw new CustomException("Attribute Not Found");
            }

            return $attribute->delete();
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function forceDelete($id)
    {
        $attribute = $this->model::onlyTrashed()->find($id);

        if (!$attribute) {
            throw new CustomException("Attribute Not Found");
        }

        $attribute->forceDelete();

        return true;
    }
}
