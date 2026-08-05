<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Backend\Product\ProductCollection;
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
}
