<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\CourierSettingService;

class CourierSettingController extends BaseController
{
    public function __construct(protected CourierSettingService $service){}

    public function show(Request $request, string $slug)
    {
        $this->authorizePermission($request->user(), 'courier_settings_read', 'You have no permission for read this');

        $data = $this->service->show($slug);

        return $this->sendResponse($data, "{$slug} Courier Credentials");
    }

    public function update(Request $request, $slug)
    {
        $this->authorizePermission($request->user(), 'courier_settings_update', 'You have no permission for update this');

        $data = $this->service->update($request,$slug);

        return $this->sendResponse($data, "{$slug} updated successfully");
    }
}
