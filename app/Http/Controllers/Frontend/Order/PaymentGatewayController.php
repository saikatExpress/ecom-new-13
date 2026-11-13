<?php

namespace App\Http\Controllers\Frontend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\PaymentGatewayService;

class PaymentGatewayController extends BaseController
{
    public function __construct(protected PaymentGatewayService $service){}

    public function index(Request $request)
    {
        $paymentGateways = $this->service->list();

        return $this->sendResponse($paymentGateways, "Payment Gateway List");
    }
}
