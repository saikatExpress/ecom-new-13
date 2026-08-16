<?php

namespace App\Http\Controllers\Backend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\BannerService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\CMS\BannerRequest;
use App\Http\Resources\Backend\CMS\BannerResource;
use App\Http\Resources\Backend\CMS\BannerCollection;

class BannerController extends BaseController
{
    public function __construct(protected BannerService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'banner_read', 'You have no permission for read this');

        $banners = $this->service->index($request);

        $banners = new BannerCollection($banners);

        return $this->sendResponse($banners, "All Banners");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'banner_read', 'You have no permission for read this');

        $banners = $this->service->trashList($request);

        $banners = new BannerCollection($banners);

        return $this->sendResponse($banners, "All Banners");
    }

    public function store(BannerRequest $request)
    {
        $this->authorizePermission($request->user(), 'banner_create', 'You have no permission for create this');

        $banner = $this->service->store($request);

        $banner = new BannerResource($banner);

        return $this->sendResponse($banner, "Banner create successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'banner_read', 'You have no permission for show this');

        $banner = $this->service->show($id);

        $banner = new BannerResource($banner);

        return $this->sendResponse($banner, "Banner Show");
    }

    public function update(BannerRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'banner_update', 'You have no permission for update this');

        $banner = $this->service->update($request, $id);

        $banner = new BannerResource($banner);

        return $this->sendResponse($banner, "Banner update successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'banner_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Banner delete successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'banner_read', 'You have no permission for show this');

        $banner = $this->service->restore($id);

        $banner = new BannerResource($banner);

        return $this->sendResponse($banner, "Banner restore successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'banner_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Banner delete permanently");
    }
}
