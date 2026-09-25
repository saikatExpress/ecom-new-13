<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Setting\SettingService;
use App\Http\Requests\Backend\Setting\SettingStoreRequest;

class SettingController extends BaseController
{
    public function __construct(protected SettingService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'setting_read', 'You have no permission for read this.');

        $settings = $this->service->index($request);

        return $this->sendResponse($settings, "Setting Data");
    }

    public function store(SettingStoreRequest $request)
    {
        $this->authorizePermission($request->user(), 'setting_create', 'You have no permission for create this');

        $setting = $this->service->store($request);

        return $this->sendResponse($setting, "Setting Create Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'setting_read', 'You have no permission for show this');

        $setting = $this->service->show($id);

        return $this->sendResponse($setting, "Setting Show");
    }

    public function update(SettingStoreRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'setting_update', 'You have no permission for update this');

        $setting = $this->service->update($request, $id);

        return $this->sendResponse($setting, "Setting Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'setting_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Setting Delete Successfully");
    }
}
