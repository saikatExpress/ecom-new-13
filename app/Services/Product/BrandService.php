<?php

namespace App\Services\Product;

use App\Models\Product\Brand;

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
}
