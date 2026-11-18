<?php

namespace App\Http\Controllers\Frontend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\FaqService;
use App\Http\Controllers\BaseController;

class FaqController extends BaseController
{
    public function __construct(protected FaqService $service){}

    public function index(Request $request)
    {
        $faqs = $this->service->index();

        return $this->sendResponse($faqs, "Faq List");
    }
}
