<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\User\UserCategoryService;
use App\Http\Requests\Backend\User\UserCategoryRequest;

class UserCategoryController extends BaseController
{
    public function __construct(protected UserCategoryService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'user_category_read', 'You have no permission for read this');

        $categories = $this->service->index();

        return $this->sendResponse($categories, 'User Category List');
    }

    public function list()
    {
        $categories = $this->service->list();

        return $this->sendResponse($categories, 'User Category List');
    }

    public function store(UserCategoryRequest $request)
    {
        $this->authorizePermission($request->user(), 'user_category_create', 'You have no permission for create this');

        $categories = $this->service->store($request);

        return $this->sendResponse($categories, 'User Category Create Successfully');
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_category_read', 'You have no permission for show this');

        $category = $this->service->show($id);

        return $this->sendResponse($category, 'User Category Show');
    }

    public function update(UserCategoryRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_category_update', 'You have no permission for update this');

        $category = $this->service->update($request, $id);

        return $this->sendResponse($category, 'User Category Update Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_category_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], 'User Category delete successfully');
    }
}
