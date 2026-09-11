<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\OrderRequest;
use App\Http\Resources\Backend\Order\OrderCollection;
use App\Http\Resources\Backend\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function __construct(protected OrderService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'order_read', 'You have no permission for read this');

        $orders = $this->service->index($request);

        $orders = new OrderCollection($orders);

        return $this->sendResponse($orders, "Order List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'order_read', 'You have no permission for read this');

        $orders = $this->service->trashList($request);

        $orders = new OrderCollection($orders);

        return $this->sendResponse($orders, "Order List");
    }

    public function store(OrderRequest $request)
    {
        $this->authorizePermission($request->user(), 'order_create', 'You have no permission for create this');

        $order = $this->service->store($request);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_read', 'You have no permission for show this');

        $order = $this->service->show($id);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Show");
    }

    public function update(OrderRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_update', 'You have no permission for update this');

        $order = $this->service->update($request, $id);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Order Deleted Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_read', 'You have no permission for show this');

        $order = $this->service->restore($id);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'order_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Order Deleted Permanently");
    }
}
