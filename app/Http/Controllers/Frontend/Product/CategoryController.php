<?php

namespace App\Http\Controllers\Frontend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\CategoryService;
use App\Http\Resources\Frontend\Product\CategoryCollection;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $service){}

    public function index(Request $request)
    {
        $request->merge(['status' => 'active']);

        $categories = $this->service->index($request);

        $categories = new CategoryCollection($categories);

        return $this->sendResponse($categories, "Category List");
    }
}
