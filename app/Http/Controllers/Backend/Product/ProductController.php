<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'product_read', 'You have no permission for view products');

        return $this->sendResponse([], "Product List");
    }
}
