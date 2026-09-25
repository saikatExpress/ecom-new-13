<?php

namespace App\Http\Controllers\Frontend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\SliderService;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Frontend\CMS\SliderResource;
use App\Http\Resources\Frontend\CMS\SliderCollection;

class SliderController extends BaseController
{
    public function __construct(protected SliderService $service){}

    public function index(Request $request)
    {
        $sliders = $this->service->index($request);

        $sliders = new SliderCollection($sliders);

        return $this->sendResponse($sliders, "Slider List");
    }

    public function show($id)
    {
        $slider = $this->service->show($id);

        $slider = new SliderResource($slider);

        return $this->sendResponse($slider, "Slider Show");
    }
}
