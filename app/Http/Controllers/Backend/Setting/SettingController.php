<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Setting\SettingService;

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
    }
}
