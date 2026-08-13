<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Blog\BlogCategoryService;
use App\Http\Requests\Backend\Blog\BlogCategoryRequest;

class BlogCategoryController extends BaseController
{
    public function __construct(protected BlogCategoryService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'blog_category_read', 'You have no permission for read this');

        $results = $this->service->index();

        return $this->sendResponse($results, "Blog Category List");
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, 'Blog Category List');
    }

    public function store(BlogCategoryRequest $request)
    {
        $this->authorizePermission($request->user(), 'blog_category_create', 'You have no permission for create this');

        $results = $this->service->store($request);

        return $this->sendResponse($results, "Blog Category Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_category_read', 'You have no permission for show this');

        $results = $this->service->show($id);

        return $this->sendResponse($results, "Blog Category Show");
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_category_update', 'You have no permission for update this');

        $results = $this->service->update($request, $id);

        return $this->sendResponse($results, "Blog Category Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'blog_category_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Blog Category Delete Successfully");
    }
}
