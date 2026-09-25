<?php

namespace App\Http\Controllers\Frontend\Product;

use Illuminate\Http\Request;
use App\Services\Product\BrandService;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Frontend\Product\BrandCollection;

class BrandController extends BaseController
{
    public function __construct(protected BrandService $service){}

    public function index(Request $request)
    {
        $request->merge(['status' => 'active']);

        $brands = $this->service->index($request);

        $brands = new BrandCollection($brands);

        return $this->sendResponse($brands, "Brand List");
    }
}
