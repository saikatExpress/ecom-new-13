<?php

namespace App\Http\Controllers\Frontend\Order;

use App\Services\Order\CouponService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Frontend\Order\CouponApplyRequest;

class CouponController extends BaseController
{
    public function __construct(protected CouponService $service){}

    public function apply(CouponApplyRequest $request)
    {
        $result = $this->service->apply($request->validated());

        $message = $result['message'];

        unset($result['message']);

        return $this->sendResponse($result,$message);
    }
}
