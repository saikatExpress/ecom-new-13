<?php

namespace App\Http\Controllers\Backend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\SliderService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\CMS\SliderRequest;
use App\Http\Resources\Backend\CMS\SliderCollection;
use App\Http\Resources\Backend\CMS\SliderResource;

class SliderController extends BaseController
{
    public function __construct(protected SliderService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'slider_read', 'You have no permission for read this');

        $sliders = $this->service->index($request);

        $sliders = new SliderCollection($sliders);

        return $this->sendResponse($sliders, "Slider List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'slider_read', 'You have no permission for read this');

        $sliders = $this->service->trashList($request);

        $sliders = new SliderCollection($sliders);

        return $this->sendResponse($sliders, "Slider Trash List");
    }

    public function store(SliderRequest $request)
    {
        $this->authorizePermission($request->user(), 'slider_create', 'You have no permission for create this');

        $slider = $this->service->store($request);

        $slider = new SliderResource($slider);

        return $this->sendResponse($slider, "Slider Create Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'slider_read', 'You have no permission for show this');

        $slider = $this->service->show($id);

        $slider = new SliderResource($slider);

        return $this->sendResponse($slider, "Slider Show");
    }

    public function update(SliderRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'slider_update', 'You have no permission for update this');

        $slider = $this->service->update($request, $id);

        $slider = new SliderResource($slider);

        return $this->sendResponse($slider, "Slider Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'slider_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Slider delete successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'slider_read', 'You have no permission for restore this');

        $slider = $this->service->restore($id);

        $slider = new SliderResource($slider);

        return $this->sendResponse($slider, "Slider restore successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'slider_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Slider permanent delete successfully");
    }
}
