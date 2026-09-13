<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\BaseController;
use App\Services\Order\FraudChekerService;
use App\Http\Requests\Backend\Order\FraudCheckRequest;

class FraudCheckerController extends BaseController
{
    public function __construct(protected FraudChekerService $service){}

    public function fraudCheck(FraudCheckRequest $request)
    {
        $this->authorizePermission($request->user(), 'fraud_check_read', 'You have no permission for read this');

        $result = $this->service->fraudCheck($request);

        return $this->sendResponse($result, "Courier Data");
    }
}
