<?php

namespace App\Http\Controllers\Frontend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Http\Resources\Frontend\Product\ProductResource;
use App\Http\Resources\Frontend\Product\ProductCollection;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $service){}

    public function index(Request $request)
    {
        $products = $this->service->index($request);

        $products = new ProductCollection($products);

        return $this->sendResponse($products, "All Products");
    }

    public function show($slug)
    {
        $product = $this->service->show($slug, 'slug');

        $product = new ProductResource($product);

        return $this->sendResponse($product, "Product Show");
    }
}
