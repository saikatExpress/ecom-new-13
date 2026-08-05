<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Product\AttributeValueRequest;
use App\Http\Resources\Backend\Product\AttributeValueCollection;
use App\Http\Resources\Backend\Product\AttributeValueResource;
use App\Services\Product\AttributeValueService;

class AttributeValueController extends BaseController
{
    public function __construct(protected AttributeValueService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'attribute_value_read','You do not have permission to view attribute value.');

        $attributeValues = $this->service->index($request);

        $attributeValues = new AttributeValueCollection($attributeValues);

        return $this->sendResponse($attributeValues, "Atrribute Value List");
    }

    public function store(AttributeValueRequest $request)
    {
        $this->authorizePermission($request->user(),'attribute_value_create','You do not have permission to create attribute value.');

        $attributeValue = $this->service->store($request);

        $attributeValue = new AttributeValueResource($attributeValue);

        return $this->sendResponse($attributeValue, "Attribute Value Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_value_read','You do not have permission to view attribute value.');

        $attributeValue = $this->service->show($id);

        $attributeValue = new AttributeValueResource($attributeValue);

        return $this->sendResponse($attributeValue, "Attribute Value Show Successfully");
    }

    public function update(AttributeValueRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_value_update','You do not have permission to update attribute value.');

        $attributeValue = $this->service->update($request, $id);

        $attributeValue = new AttributeValueResource($attributeValue);

        return $this->sendResponse($attributeValue, "Attribute Value Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'attribute_value_delete','You do not have permission to delete attribute value.');

        $this->service->destroy($id);

        return $this->sendResponse([], "Attribute Value Delete Successfully");
    }
}
