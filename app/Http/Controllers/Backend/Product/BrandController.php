<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Services\Product\BrandService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\BrandRequest;
use App\Http\Resources\Backend\Product\BrandResource;
use App\Http\Resources\Backend\Product\BrandCollection;

class BrandController extends BaseController
{
    public function __construct(protected BrandService $service){}
    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'brand_read','You do not have permission to view brands.');

        $brands = $this->service->index($request);

        $brands = new BrandCollection($brands);

        return $this->sendResponse($brands, "Brand List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(),'brand_read','You do not have permission to view brands.');

        $brands = $this->service->trashList($request);

        $brands = new BrandCollection($brands);

        return $this->sendResponse($brands, "Brand List");
    }

    public function store(BrandRequest $request)
    {
        $this->authorizePermission($request->user(),'brand_create','You do not have permission to create brands.');

        $brand = $this->service->store($request);

        $brand = new BrandResource($brand);

        return $this->sendResponse($brand, "Brand Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'brand_read','You do not have permission to view brands.');

        $brand = $this->service->show($id);

        $brand = new BrandResource($brand);

        return $this->sendResponse($brand, "Brand Show Successfully");
    }

    public function update(BrandRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'brand_update','You do not have permission to update brands.');

        $brand = $this->service->update($request, $id);

        $brand = new BrandResource($brand);

        return $this->sendResponse($brand, "Brand Update Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'brand_update','You do not have permission to update brands.');

        $brand = $this->service->restore($id);

        $brand = new BrandResource($brand);

        return $this->sendResponse($brand, "Brand Restore Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'brand_delete','You do not have permission to delete brands.');

        $this->service->destroy($id);

        return $this->sendResponse([], "Brand Delete Successfully");
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'brand_delete','You do not have permission to delete brands.');

        $this->service->forceDelete($id);

        return $this->sendResponse([], "Brand Delete Permanently");
    }
}
