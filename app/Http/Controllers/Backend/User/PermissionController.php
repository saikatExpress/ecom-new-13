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

        $permissions = $this->model::query()
        ->orderBy('module')
        ->orderBy('resource')
        ->orderBy('name')
        ->get()
        ->groupBy('module')
        ->map(function ($permissions, $module) {
            return [
                'module' => $module,

                'resources' => $permissions
                    ->groupBy('resource')
                    ->map(function ($permissions, $resource) {
                        return [
                            'resource' => $resource,
                            'permissions' => $permissions->values(),
                        ];
                    })
                    ->values(),
            ];
        })
        ->values();

        return $this->sendResponse($permissions, "Permission List");
    }
}
