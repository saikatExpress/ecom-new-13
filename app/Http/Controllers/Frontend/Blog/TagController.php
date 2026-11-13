<?php

namespace App\Http\Controllers\Frontend\Blog;

use Illuminate\Http\Request;
use App\Services\Blog\TagService;
use App\Http\Controllers\BaseController;

class TagController extends BaseController
{
    public function __construct(protected TagService $service){}

    public function index(Request $request)
    {
        $tags = $this->service->list();

        return $this->sendResponse($tags, "Tag List");
    }
}
