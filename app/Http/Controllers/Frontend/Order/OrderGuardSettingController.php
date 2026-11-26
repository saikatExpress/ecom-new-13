<?php

namespace App\Http\Controllers\Frontend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\OrderGuardSettingService;

class OrderGuardSettingController extends BaseController
{
    public function __construct(protected OrderGuardSettingService $service){}

    public function show(Request $request)
    {
        $orderGuard = $this->service->show();

        return $this->sendResponse($orderGuard, "Order Guard Setting");
    }
}
