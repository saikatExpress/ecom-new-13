<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\CustomerTypeRequest;
use App\Services\Order\CustomerTypeService;

class CustomerTypeController extends BaseController
{
    public function __construct(protected CustomerTypeService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'customer_type_read', 'You have no permission for read this');

        $results = $this->service->index($request);

        return $this->sendResponse($results, "Customer Type List");
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, "Customer Type List");
    }

    public function store(CustomerTypeRequest $request)
    {
        $this->authorizePermission($request->user(), 'customer_type_create', 'You have no permission for create this');

        $result = $this->service->store($request);

        return $this->sendResponse($result, "Customer Type Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'customer_type_read', 'You have no permission for show this');

        $result = $this->service->show($id);

        return $this->sendResponse($result, "Customer Type Show");
    }

    public function update(CustomerTypeRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'customer_type_update', 'You have no permission for update this');

        $result = $this->service->update($request, $id);

        return $this->sendResponse($result, "Customer Type Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'customer_type_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Customer Type Deleted Successfully");
    }
}
