<?php

namespace App\Http\Controllers\Frontend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\DeliveryGatewayService;

class DeliveryGatewayController extends BaseController
{
    public function __construct(protected DeliveryGatewayService $service){}

    public function index(Request $request)
    {
        $deliveryGateways = $this->service->list();

        return $this->sendResponse($deliveryGateways, "Delivery Gateway List");
    }
}
