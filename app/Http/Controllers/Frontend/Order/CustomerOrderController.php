<?php

namespace App\Http\Controllers\Frontend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\CustomerOrderService;
use App\Http\Requests\Backend\Order\OrderRequest;
use App\Http\Resources\Frontend\Order\OrderResource;

class CustomerOrderController extends BaseController
{
    public function __construct(protected CustomerOrderService $service){}

    public function store(OrderRequest $request)
    {
        $order = $this->service->store($request);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $order = $this->service->show($request, $id);

        $order = new OrderResource($order);

        return $this->sendResponse($order, "Order Show");
    }
}
