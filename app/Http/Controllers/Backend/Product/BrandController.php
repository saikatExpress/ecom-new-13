<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\BrandService;

class BrandController extends BaseController
{
    public function __construct(protected BrandService $service){}
    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'brand_read','You do not have permission to view brands.');

        $brands = $this->service->index($request);

        return $this->sendResponse($brands, "Brand List");
    }
}
