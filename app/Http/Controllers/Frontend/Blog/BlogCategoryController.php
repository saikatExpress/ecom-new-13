<?php

namespace App\Http\Controllers\Frontend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Blog\BlogCategoryService;

class BlogCategoryController extends BaseController
{
    public function __construct(protected BlogCategoryService $service){}

    public function index(Request $request)
    {
        $categories = $this->service->list();

        return $this->sendResponse($categories, "Blog Categories List");
    }
}
