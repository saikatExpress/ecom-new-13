<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\User\UserRequest;
use App\Http\Resources\Backend\User\UserResource;
use App\Http\Resources\Backend\User\UserCollection;

class UserController extends BaseController
{
    public function __construct(protected UserService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'user_read', 'You have no permission for read this');

        $users = $this->service->index($request);

        $users = new UserCollection($users);

        return $this->sendResponse($users, "All Users");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'user_read', 'You have no permission for read this');

        $users = $this->service->trashList($request);

        $users = new UserCollection($users);

        return $this->sendResponse($users, "Trash List");
    }

    public function store(UserRequest $request)
    {
        $this->authorizePermission($request->user(), 'user_create', 'You have no permission for create this');

        $user = $this->service->store($request);

        $user = new UserResource($user);

        return $this->sendResponse($user, 'User Create Successfully');
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_read', 'You have no permission for show this');

        $user = $this->service->show($id);

        $user = new UserResource($user);

        return $this->sendResponse($user, 'User show');
    }

    public function update(UserRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_update', 'You have no permission for update this');

        $user = $this->service->update($request, $id);

        $user = new UserResource($user);

        return $this->sendResponse($user, 'User Update Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], 'User Delete Successfully');
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_read', 'You have no permission for show this');

        $user = $this->service->restore($id);

        $user = new UserResource($user);

        return $this->sendResponse($user, 'User Restore Successfully');
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'user_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], 'User Delete Permanently');
    }
}
