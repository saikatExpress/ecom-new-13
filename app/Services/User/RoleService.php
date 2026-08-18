<?php

namespace App\Services\User;

use App\Exceptions\CustomException;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleService
{
    public function __construct(protected Role $model){}

    public function index()
    {
        $roles = $this->model::all();

        return $roles;
    }

    public function list()
    {
        $roles = $this->model::select('id', 'display_name')->where('status', 'active')->get();

        return $roles;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $role = new $this->model();

            $role->name         = Str::lower(str_replace(' ', '', $request->name));
            $role->display_name = Str::title($request->display_name);
            $role->description  = $request->description ?? null;
            $role->save();

            if ($request->has('permission_ids') && is_array($request->permission_ids)) {
                $role->permissions()->sync($request->permission_ids);
            }

            return $role->load('permissions');
        });
    }

    public function show($id)
    {
        $role = $this->model::with('permissions:id,name,display_name')->find($id);

        if (!$role) {
            throw new CustomException('Role not found');
        }

        return $role;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $role = $this->model::find($id);

            if (!$role) {
                throw new CustomException('Role not found');
            }

            $role->name         = Str::lower(str_replace(' ', '', $request->name));
            $role->display_name = Str::title($request->display_name);
            $role->description  = $request->description ?? null;
            $role->save();

            if ($request->has('permission_ids')) {
                $role->permissions()->sync($request->permission_ids ?? []);
            }

            return $role->fresh()->load('permissions');
        });
    }

    public function destroy($id)
    {
        $role = $this->model::find($id);

        if (!$role) {
            throw new CustomException('Role not found');
        }

        if ($role->users()->exists()) {
            throw new CustomException('This role is assigned to users and cannot be deleted.');
        }

        $role->permissions()->detach();

        $role->delete();

        return true;
    }
}
