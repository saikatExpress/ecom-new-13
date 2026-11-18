<?php

namespace App\Http\Controllers\Frontend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\CmsService;
use App\Http\Controllers\BaseController;

class CmsController extends BaseController
{
    public function __construct(protected CmsService $service){}

    public function show(Request $request, string $slug)
    {
        $page = $this->service->show($slug);

        return $this->sendResponse($page, "Page Show");
    }
}
