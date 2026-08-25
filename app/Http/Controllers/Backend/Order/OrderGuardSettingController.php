<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\OrderGuardSettingService;
use App\Http\Requests\Backend\Order\OrderGuardSettingRequest;

class OrderGuardSettingController extends BaseController
{
    public function __construct(protected OrderGuardSettingService $service){}

    public function show(Request $request)
    {
        $this->authorizePermission($request->user(), 'order_guard_settings_read', 'You have no permission for show this');

        $setting = $this->service->show();

        return $this->sendResponse($setting, 'Order Guard Settings');
    }

    public function update(OrderGuardSettingRequest $request)
    {
        $this->authorizePermission($request->user(), 'order_guard_settings_update', 'You have no permission for update this');

        $setting = $this->service->update($request);

        return $this->sendResponse($setting, 'Order Guard Settings Update Successfully');
    }
}
