<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\DeliveryGatewayService;
use App\Http\Requests\Backend\Order\DeliveryGatewayRequest;

class DeliveryGatewayController extends BaseController
{
    public function __construct(protected DeliveryGatewayService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'delivery_gateway_read', 'You have no permission for read this');

        $results = $this->service->index();

        return $this->sendResponse($results, 'Delivery Gateway List');
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, 'Delivery Gateway List');
    }

    public function store(DeliveryGatewayRequest $request)
    {
        $this->authorizePermission($request->user(), 'delivery_gateway_create', 'You have no permission for create this');

        $results = $this->service->store($request);

        return $this->sendResponse($results, 'Delivery Gateway Created Successfully');
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'delivery_gateway_read', 'You have no permission for show this');

        $results = $this->service->show($id);

        return $this->sendResponse($results, 'Delivery Gateway Show');
    }

    public function update(DeliveryGatewayRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'delivery_gateway_update', 'You have no permission for update this');

        $results = $this->service->update($request, $id);

        return $this->sendResponse($results, 'Delivery Gateway Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'delivery_gateway_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], 'Delivery Gateway Delete Successfully');
    }
}
