<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Resources\Frontend\Blog\BlogResource;
use Illuminate\Http\Request;
use App\Services\Blog\BlogService;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Frontend\Blog\BlogCollection;

class BlogController extends BaseController
{
    public function __construct(protected BlogService $service){}

    public function index(Request $request)
    {
        $blogs = $this->service->index($request);

        $blogs = new BlogCollection($blogs);

        return $this->sendResponse($blogs, "Blog List");
    }

    public function show($id)
    {
        $blog = $this->service->show($id);

        $blog = new BlogResource($blog);

        return $this->sendResponse($blog, "Blog Show");
    }
}
