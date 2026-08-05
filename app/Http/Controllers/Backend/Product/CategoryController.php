<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Resources\Backend\Product\CategoryCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\CategoryRequest;
use App\Http\Resources\Backend\Product\CategoryResource;
use App\Services\Product\CategoryService;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'category_read','You do not have permission to view categories.');

        $categories = $this->service->index($request);

        $categories = new CategoryCollection($categories);

        return $this->sendResponse($categories, "Categories List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(),'category_read','You do not have permission to view categories.');

        $categories = $this->service->trashList($request);

        $categories = new CategoryCollection($categories);

        return $this->sendResponse($categories, "Category Trash List");
    }

    public function store(CategoryRequest $request)
    {
        $this->authorizePermission($request->user(),'category_create','You do not have permission to create categories.');

        $category = $this->service->store($request);

        $category = new CategoryResource($category);

        return $this->sendResponse($category, "Category Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'category_read','You do not have permission to view categories.');

        $category = $this->service->show($id);

        $category = new CategoryResource($category);

        return $this->sendResponse($category, "Category Show Successfully");
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'category_update','You do not have permission to update categories.');

        $category = $this->service->update($request, $id);

        $category = new CategoryResource($category);

        return $this->sendResponse($category, "Category Update Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'category_update','You do not have permission to update categories.');

        $category = $this->service->restore($id);

        $category = new CategoryResource($category);

        return $this->sendResponse($category, "Category Restore Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'category_delete','You do not have permission to delete categories.');

        $this->service->destroy($id);

        return $this->sendResponse([], "Category Delete Successfully");
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'category_delete','You do not have permission to delete categories.');

        $this->service->forceDelete($id);

        return $this->sendResponse([], "Category Delete Permanently");
    }
}
