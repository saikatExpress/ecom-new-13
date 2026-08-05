<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\SubCategoryRequest;
use App\Http\Resources\Backend\Product\SubCategoryCollection;
use App\Http\Resources\Backend\Product\SubCategoryResource;
use App\Services\Product\SubCategoryService;

class SubCategoryController extends BaseController
{
    public function __construct(protected SubCategoryService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'sub_category_read', 'You have no permission for view sub categories');

        $subCategories = $this->service->index($request);

        $subCategories = new SubCategoryCollection($subCategories);

        return $this->sendResponse($subCategories, "Sub Categories List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(),'sub_category_read','You do not have permission to view sub categories.');

        $subCategories = $this->service->trashList($request);

        $subCategories = new SubCategoryCollection($subCategories);

        return $this->sendResponse($subCategories, "Category Trash List");
    }

    public function store(SubCategoryRequest $request)
    {
        $this->authorizePermission($request->user(),'sub_category_create','You do not have permission to create sub categories.');

        $subCategory = $this->service->store($request);

        $subCategory = new SubCategoryResource($subCategory);

        return $this->sendResponse($subCategory, "Sub Category Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'sub_category_read','You do not have permission to view categories.');

        $subCategory = $this->service->show($id);

        $subCategory = new SubCategoryResource($subCategory);

        return $this->sendResponse($subCategory, "Sub Category Show Successfully");
    }

    public function update(SubCategoryRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'sub_category_update','You do not have permission to update sub categories.');

        $subCategory = $this->service->update($request, $id);

        $subCategory = new SubCategoryResource($subCategory);

        return $this->sendResponse($subCategory, "Sub Category Update Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'sub_category_update','You do not have permission to update sub categories.');

        $subCategory = $this->service->restore($id);

        $subCategory = new SubCategoryResource($subCategory);

        return $this->sendResponse($subCategory, "Sub Category Restore Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'sub_category_delete','You do not have permission to delete sub categories.');

        $this->service->destroy($id);

        return $this->sendResponse([], "Sub Category Delete Successfully");
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'sub_category_delete','You do not have permission to delete sub categories.');

        $this->service->forceDelete($id);

        return $this->sendResponse([], "Sub Category Delete Permanently");
    }
}
