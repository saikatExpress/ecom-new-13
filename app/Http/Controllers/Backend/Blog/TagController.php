<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Services\Blog\TagService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Blog\TagRequest;

class TagController extends BaseController
{
    public function __construct(protected TagService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'tag_read', 'You have no permission for read this');

        $tags = $this->service->index($request);

        return $this->sendResponse($tags, "Tag List");
    }

    public function list()
    {
        $tags = $this->service->list();

        return $this->sendResponse($tags, "Tag List");
    }

    public function store(TagRequest $request)
    {
        $this->authorizePermission($request->user(), 'tag_create', 'You have no permission for create this');

        $tag = $this->service->store($request);

        return $this->sendResponse($tag, "Tag created successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'tag_read', 'You have no permission for view this');

        $tag = $this->service->show($id);

        return $this->sendResponse($tag, "Tag View");
    }

    public function update(TagRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'tag_update', 'You have no permission for update this');

        $tag = $this->service->update($request, $id);

        return $this->sendResponse($tag, "Tag updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'tag_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Tag deleted successfully");
    }
}
