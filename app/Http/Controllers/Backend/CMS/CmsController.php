<?php

namespace App\Http\Controllers\Backend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\CmsService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\CMS\CmsRequest;

class CmsController extends BaseController
{
    public function __construct(protected CmsService $service){}

    public function show(Request $request, string $slug)
    {
        $this->authorizePermission($request->user(), 'cms_read', 'You have no permission for view this page');

        $page = $this->service->show($slug);

        return $this->sendResponse($page, "Page Show");
    }

    public function updatePage(CmsRequest $request, string $slug)
    {
        $this->authorizePermission($request->user(), 'cms_update', 'You have no permission for update this page');

        $page = $this->service->updatePage($request, $slug);

        return $this->sendResponse($page, "Page updated successfully");
    }
}
