<?php

namespace App\Http\Controllers\Frontend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\SectionService;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Frontend\CMS\SectionCollection;

class SectionController extends BaseController
{
    public function __construct(protected SectionService $service){}

    public function index(Request $request)
    {
        $request->merge(['status' => 'active']);

        $sections = $this->service->index($request);

        $sections = new SectionCollection($sections);

        return $this->sendResponse($sections, "Section List");
    }
}
