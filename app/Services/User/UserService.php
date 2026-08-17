<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    public function __construct(protected User $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $roleIds      = $request->input('role_ids', []);

        $users = $this->model
            ->when($roleIds, function ($query, $roleIds) {
                $query->whereHas('roles', function ($query) use ($roleIds) {
                    $query->whereIn('roles.id', $roleIds);
                });
            })
            ->paginate($paginateSize);

        return $users;
    }
}
