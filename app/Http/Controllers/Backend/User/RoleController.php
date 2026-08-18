<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;
use App\Services\User\RoleService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\User\RoleRequest;

class RoleController extends BaseController
{
    public function __construct(protected RoleService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'role_create', 'You have no permission for read this');

        $roles = $this->service->index();

        return $this->sendResponse($roles, "Role List");
    }

    public function list()
    {
        $roles = $this->service->list();

        return $this->sendResponse($roles, "Role List");
    }

    public function store(RoleRequest $request)
    {
        $this->authorizePermission($request->user(), 'role_create', 'You have no permission for create this');

        $roles = $this->service->store($request);

        return $this->sendResponse($roles, "Role Create Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'role_read', 'You have no permission for show this');

        $role = $this->service->show($id);

        return $this->sendResponse($role, "Role Show");
    }

    public function update(RoleRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'role_update', 'You have no permission for update this');

        $roles = $this->service->update($request, $id);

        return $this->sendResponse($roles, "Role Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'role_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Role Delete Successfully");
    }
}
