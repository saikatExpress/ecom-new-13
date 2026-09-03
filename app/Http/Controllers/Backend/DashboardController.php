<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'dashboard_read', 'You have no permission for read this page');

        return $this->sendResponse([], "Dashboard Data");
    }

    public function clearCache()
    {
        Artisan::call('optimize:clear');

        $output = Artisan::output();

        return $this->sendResponse($output, "All caches cleared successfully!");
    }
}
