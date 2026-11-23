<?php

namespace App\Http\Controllers\Frontend\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Setting\SettingService;

class SettingController extends BaseController
{
    public function __construct(protected SettingService $service){}

    public function index(Request $request)
    {
        $settings = $this->service->index($request);

        return $this->sendResponse($settings, "Setting List");
    }
}
