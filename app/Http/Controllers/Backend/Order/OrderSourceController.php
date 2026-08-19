<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\OrderSourceService;
use App\Http\Requests\Backend\Order\OrderSourceRequest;

class OrderSourceController extends BaseController
{
    public function __construct(protected OrderSourceService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'order_source_read', 'You have no permission for read this');

        $results = $this->service->index($request);

        return $this->sendResponse($results, "Order Source List");
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, "Order Source List");
    }

    public function store(OrderSourceRequest $request)
    {
        $this->authorizePermission($request->user(), 'order_source_create', 'You have no permission for create this');

        $orderSource = $this->service->store($request);

        return $this->sendResponse($orderSource, "Order Source Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_source_read', 'You have no permission for show this');

        $orderSource = $this->service->show($id);

        return $this->sendResponse($orderSource, "Order Source Show");
    }

    public function update(OrderSourceRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_source_update', 'You have no permission for update this');

        $orderSource = $this->service->update($request, $id);

        return $this->sendResponse($orderSource, "Order Source Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_source_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Order Source Delete Successfully");
    }
}
