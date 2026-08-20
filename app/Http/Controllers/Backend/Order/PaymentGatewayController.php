<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\PaymentGatewayService;
use App\Http\Requests\Backend\Order\PaymentGatewayRequest;
use App\Http\Resources\Backend\Order\PaymentGatewayResource;
use App\Http\Resources\Backend\Order\PaymentGatewayCollection;

class PaymentGatewayController extends BaseController
{
    public function __construct(protected PaymentGatewayService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_read', 'You have no permission for read this');

        $results = $this->service->index($request);

        $results = new PaymentGatewayCollection($results);

        return $this->sendResponse($results, 'Payment Gateway List');
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_read', 'You have no permission for read this');

        $results = $this->service->trashList($request);

        $results = new PaymentGatewayCollection($results);

        return $this->sendResponse($results, 'Payment Gateway Trash List');
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, 'Payment Gateway List');
    }

    public function store(PaymentGatewayRequest $request)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_create', 'You have no permission for create this');

        $paymentGateway = $this->service->store($request);

        $paymentGateway = new PaymentGatewayResource($paymentGateway);

        return $this->sendResponse($paymentGateway, 'Payment Gateway Create Successfully');
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_read', 'You have no permission for show this');

        $paymentGateway = $this->service->show($id);

        $paymentGateway = new PaymentGatewayResource($paymentGateway);

        return $this->sendResponse($paymentGateway, 'Payment Gateway show');
    }

    public function update(PaymentGatewayRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_update', 'You have no permission for update this');

        $paymentGateway = $this->service->update($request, $id);

        $paymentGateway = new PaymentGatewayResource($paymentGateway);

        return $this->sendResponse($paymentGateway, 'Payment Gateway Update Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], 'Payment Gateway Delete Successfully');
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_read', 'You have no permission for show this');

        $paymentGateway = $this->service->restore($id);

        $paymentGateway = new PaymentGatewayResource($paymentGateway);

        return $this->sendResponse($paymentGateway, 'Payment Gateway Restore Successfully');
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'payment_gateway_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], 'Payment Gateway Delete Permanently');
    }
}
