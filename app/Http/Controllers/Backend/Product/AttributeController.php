<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\AttributeRequest;
use App\Http\Resources\Backend\Product\AttributeCollection;
use App\Http\Resources\Backend\Product\AttributeResource;
use App\Services\Product\AttributeService;

class AttributeController extends BaseController
{
    public function __construct(protected AttributeService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'attribute_read','You do not have permission to view attribute.');

        $attributes = $this->service->index($request);

        $attributes = new AttributeCollection($attributes);

        return $this->sendResponse($attributes, "Atrribute List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(),'attribute_read','You do not have permission to view attribute.');

        $attributes = $this->service->trashList($request);

        $attributes = new AttributeCollection($attributes);

        return $this->sendResponse($attributes, "Atrribute List");
    }

    public function store(AttributeRequest $request)
    {
        $this->authorizePermission($request->user(),'attribute_create','You do not have permission to create attribute.');

        $attribute = $this->service->store($request);

        $attribute = new AttributeResource($attribute);

        return $this->sendResponse($attribute, "Attribute Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_show','You do not have permission to view attribute.');

        $attribute = $this->service->show($id);

        $attribute = new AttributeResource($attribute);

        return $this->sendResponse($attribute, "Attribute Show Successfully");
    }

    public function update(AttributeRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_update','You do not have permission to update attribute.');

        $attribute = $this->service->update($request, $id);

        $attribute = new AttributeResource($attribute);

        return $this->sendResponse($attribute, "Attribute Update Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_update','You do not have permission to update attribute.');

        $attribute = $this->service->restore($id);

        $attribute = new AttributeResource($attribute);

        return $this->sendResponse($attribute, "Attribute Restore Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_delete','You do not have permission to delete attribute.');

        $this->service->destroy($id);

        return $this->sendResponse([], "Attribute Delete Successfully");
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_delete','You do not have permission to delete attribute.');

        $this->service->forceDelete($id);

        return $this->sendResponse([], "Attribute Delete Permanently");
    }
}
