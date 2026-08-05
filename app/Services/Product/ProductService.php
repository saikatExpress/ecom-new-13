<?php

namespace App\Services\Product;

use App\Models\Product\Product;

class ProductService
{
    public function __construct(protected Product $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $products = $this->model->query()
        ->with(['category', 'brand'])

        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        })

        ->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->input('category_id'));
        })

        ->when($request->filled('brand_id'), function ($query) use ($request) {
            $query->where('brand_id', $request->input('brand_id'));
        })

        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->input('status'));
        })

        ->latest()

        ->paginate($paginateSize);

        return $products;
    }
}
