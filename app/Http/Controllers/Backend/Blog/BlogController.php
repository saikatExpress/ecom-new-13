<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Resources\Backend\Blog\BlogCollection;
use App\Http\Resources\Backend\Blog\BlogResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Blog\BlogRequest;
use App\Services\Blog\BlogService;

class BlogController extends BaseController
{
    public function __construct(protected BlogService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'blog_read', 'You have no permission for read this');

        $blogs = $this->service->index($request);

        $blogs = new BlogCollection($blogs);

        return $this->sendResponse($blogs, "Blog List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'blog_read', 'You have no permission for read this');

        $blogs = $this->service->index($request);

        $blogs = new BlogCollection($blogs);

        return $this->sendResponse($blogs, "Blog Trash List");
    }

    public function store(BlogRequest $request)
    {
        $this->authorizePermission($request->user(), 'blog_create', 'You have no permission for create this');

        $blog = $this->service->store($request);

        $blog = new BlogResource($blog);

        return $this->sendResponse($blog, "Blog Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_read', 'You have no permission for show this');

        $blog = $this->service->show($id);

        $blog = new BlogResource($id);

        return $this->sendResponse($blog, "Blog Show Successfully");
    }

    public function update(BlogRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_update', 'You have no permission for update this');

        $blog = $this->service->update($request, $id);

        $blog = new BlogResource($blog);

        return $this->sendResponse($blog, "Blog Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Blog Delete Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_read', 'You have no permission for show this');

        $blog = $this->service->restore($id);

        $blog = new BlogResource($id);

        return $this->sendResponse($blog, "Blog Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_read', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Blog Permanent Delete Successfully");
    }
}
