<?php

namespace App\Http\Controllers\Backend\User;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class PermissionController extends BaseController
{
    public function __construct(protected Permission $model){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'permission_read', 'You have no permission for read this');

        $permissions = $this->model::all()
        ->groupBy('module')
        ->map(function ($permissions, $module) {
            return [
                'module' => $module,
                'permissions' => $permissions,
            ];
        })
        ->values();

        return $this->sendResponse($permissions, "Permission List");
    }
}
