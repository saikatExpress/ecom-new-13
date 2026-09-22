<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Services\Order\OrderService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\OrderRequest;
use App\Http\Resources\Backend\Order\OrderResource;
use App\Http\Resources\Backend\Order\OrderCollection;

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

        return $this->sendResponse($orders, "Order List");
    }

    public function history(Request $request)
    {
        $history = $this->service->history($request);

        return $this->sendResponse($history, "Order History");
    }

    public function store(OrderRequest $request)
    {
        $this->authorizePermission($request->user(), 'order_create', 'You have no permission for create this');

        $order = $this->service->store($request);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Created Successfully");
    }

    public function statusUpdate(Request $request)
    {
        $this->authorizePermission($request->user(),'order_update','You have no permission for update order status');

        $data = $this->service->statusUpdate($request);

        return $data;

        return $this->sendResponse($data,'Order status updated successfully');
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

    public function searchByPhoneNumber(Request $request)
    {
        $this->authorizePermission($request->user(), 'order_read', 'You have no permission for read this');

        $orders = $this->service->searchByPhoneNumber($request);

        return $this->sendResponse($orders, "Order by Customer", 200);
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
