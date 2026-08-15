<?php

namespace App\Services\CMS;

use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;
use App\Models\CMS\Section;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SectionService
{
    public function __construct(protected Section $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $sections = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
            'products',
        ])
        ->paginate($paginateSize);

        return $sections;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $sections = $this->model::onlyTrashed()
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
            'products',
        ])
        ->paginate($paginateSize);

        return $sections;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $section = new $this->model();

            $section->name      = Str::title($request->name);
            $section->link      = $request->link;
            $section->is_slider = $request->is_slider ?? 0;
            $section->status    = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $section->img_path = FileUploadHelper::upload($request->file('image'), 'sections');
            }

            $section->save();

            $productIds = collect();

            if ($request->filled('category_ids')) {

                $categoryProductIds = Product::query()->whereIn('category_id', $request->category_ids)->pluck('id');

                $productIds = $productIds->merge($categoryProductIds);
            }

            if ($request->filled('product_ids')) {
                $productIds = $productIds->merge($request->product_ids);
            }

            $productIds = $productIds->unique()->values()->toArray();

            if (!empty($productIds)) {
                $section->products()->attach($productIds);
            }

            return $section->load('products');
        });
    }

    public function show($id)
    {
        $section = $this->model
        ->with('products')
        ->find($id);

        if(!$section){
            throw new CustomException("Section not found");
        }

        return $section;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $section = $this->model::find($id);

            if (!$section) {
                throw new CustomException('Section not found');
            }

            $section->name      = Str::title($request->name);
            $section->link      = $request->link;
            $section->is_slider = $request->is_slider ?? 0;
            $section->status    = $request->status;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $section->img_path = FileUploadHelper::replace($request->file('image'),$section->img_path,'sections');
            }

            $section->save();

            if ($request->has('category_ids') || $request->has('product_ids')) {
                $productIds = collect();

                if ($request->filled('category_ids')) {

                    $categoryProductIds = Product::query()->whereIn('category_id', $request->category_ids)->pluck('id');

                    $productIds = $productIds->merge($categoryProductIds);
                }

                if ($request->filled('product_ids')) {

                    $productIds = $productIds->merge($request->product_ids);
                }

                $productIds = $productIds->unique()->values()->toArray();

                $section->products()->sync($productIds);
            }

            return $section->load('products');
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $section = $this->model::find($id);

            if (!$section) {
                throw new CustomException('Section not found');
            }

            $section->delete();

            return true;
        });
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {

            $section = $this->model::onlyTrashed()->find($id);

            if (!$section) {
                throw new CustomException('Deleted section not found');
            }

            $section->restore();

            return $section->fresh()->load('products');
        });
    }

    public function permanentDelete($id)
    {
        return DB::transaction(function () use ($id) {

            $section = $this->model::onlyTrashed()->find($id);

            if (!$section) {
                throw new CustomException('Deleted section not found');
            }

            if ($section->img_path) {
                FileUploadHelper::delete($section->img_path);
            }

            $section->products()->detach();

            $section->forceDelete();

            return true;
        });
    }
}
