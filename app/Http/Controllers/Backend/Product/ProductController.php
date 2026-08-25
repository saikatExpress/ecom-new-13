<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Http\Requests\Backend\Product\ProductRequest;
use App\Http\Resources\Backend\Product\ProductResource;
use App\Http\Resources\Backend\Product\ProductCollection;

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

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'product_read', 'You have no permission for view products');

        $products = $this->service->trashList($request);

        $products = new ProductCollection($products);

        return $this->sendResponse($products, "Product Trash List");
    }

    public function search(Request $request)
    {
        $products = $this->service->search($request);

        return $this->sendResponse($products, "Product Results");
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

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'product_delete', 'You have no permission for delete product');

        $this->service->destroy($id);

        return $this->sendResponse("Product delete Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'product_read', 'You have no permission for show product');

        $product = $this->service->restore($id);

        $product = new ProductResource($product);

        return $this->sendResponse($product, "Product Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'product_delete', 'You have no permission for delete product');

        $this->service->permanentDelete($id);

        return $this->sendResponse("Product Delete Permanently");
    }
}
