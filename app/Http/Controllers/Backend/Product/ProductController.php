<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\ProductRequest;
use App\Http\Resources\Backend\Product\ProductCollection;
use App\Http\Resources\Backend\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'product_read', 'You have no permission for view products');

        $products = $this->service->index($request);

        $products = new ProductCollection($products);

        return $this->sendResponse($products, "Product List");
    }

    public function store(ProductRequest $request)
    {
        $this->authorizePermission($request->user(), 'product_create', 'You have no permission for create product');

        $product = $this->service->store($request);

        $product = new ProductResource($product);

        return $this->sendResponse($product, "Product Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'product_read', 'You have no permission for show product');

        $product = $this->service->show($id, 'id');

        $product = new ProductResource($product);

        return $this->sendResponse($product, "Single Product Show");
    }

    public function update(ProductRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'product_update', 'You have no permission for update product');

        $product = $this->service->update($request, $id);

        $product = new ProductResource($product);

        return $this->sendResponse($product, "Product Update Successfully");
    }
}
