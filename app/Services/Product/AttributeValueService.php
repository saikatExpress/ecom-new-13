<?php

namespace App\Services\Product;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Models\Product\AttributeValue;

class AttributeValueService
{
    public function __construct(protected AttributeValue $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $attributeId = $request->input('attribute_id');

        $attributeValues = $this->model
        ->with(
            'attribute:id,name,slug',
        )
        ->when($attributeId, function ($query, $attributeId) {
            $query->where('attribute_id', $attributeId);
        })
        ->orderByDesc('created_at')
        ->paginate($paginateSize);

        return $attributeValues;
    }

    public function store($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $attributeValue = new $this->model();

                $attributeValue->attribute_id = $request->attribute_id;
                $attributeValue->value = Str::title($request->value);

                $attributeValue->save();

                return $attributeValue;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $attributeValue = $this->model
            ->with(
                'attribute:id,name,slug',
            )
            ->find($id);

            if(!$attributeValue){
                throw new CustomException("Attribute Value Not Found");
            }

            return $attributeValue;
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $attributeValue = $this->model::find($id);

                if(!$attributeValue){
                    throw new CustomException("Attribute Value not found");
                }

                $attributeValue->attribute_id = $request->attribute_id;
                $attributeValue->name = Str::title($request->name);

                $attributeValue->save();

                return $attributeValue;
            });

        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $attributeValue = $this->model::find($id);

            if(!$attributeValue){
                throw new CustomException("Attribute Value Not Found");
            }

            return $attributeValue->delete();
        } catch (Exception $e) {
            info($e);
            throw $e;
        }
    }
}
