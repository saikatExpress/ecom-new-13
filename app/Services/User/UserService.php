<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\File\FileUploadHelper;

class UserService
{
    public function __construct(protected User $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryId   = $request->input('user_category_id');
        $status       = $request->input('status');
        $roleIds      = $request->input('role_ids', []);

        $users = $this->model
        ->with([
            'userCategory:id,name',
            'roles:id,name,display_name',
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->when($searchKey, function($query, $searchKey){
            $query->where('username', 'like', "%{$searchKey}%")
            ->orWhere('phone_number', 'like', "%{$searchKey}%");
        })
        ->when($categoryId, function($query, $categoryId) {
            $query->where('user_category_id', $categoryId);
        })
        ->when($roleIds, function ($query, $roleIds) {
            $query->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            });
        })
        ->when($status, function($query, $status){
            $query->where('status', $status);
        })
        ->paginate($paginateSize);

        return $users;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key');
        $categoryId   = $request->input('user_category_id');
        $status       = $request->input('status');
        $roleIds      = $request->input('role_ids', []);

        $users = $this->model::onlyTrashed()
        ->with([
            'userCategory:id,name',
            'roles:id,name,display_name',
            'deletedBy:id,username',
        ])
        ->when($searchKey, function($query, $searchKey){
            $query->where('username', 'like', "%{$searchKey}%")
            ->orWhere('phone_number', 'like', "%{$searchKey}%");
        })
        ->when($categoryId, function($query, $categoryId) {
            $query->where('user_category_id', $categoryId);
        })
        ->when($roleIds, function ($query, $roleIds) {
            $query->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            });
        })
        ->when($status, function($query, $status){
            $query->where('status', $status);
        })
        ->paginate($paginateSize);

        return $users;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $user = new $this->model();

            $user->user_category_id = $request->user_category_id;
            $user->username         = Str::title($request->username);
            $user->email            = $request->email;
            $user->phone_number     = $request->phone_number;
            $user->password         = Hash::make($request->password);
            $user->status           = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $user->img_path = FileUploadHelper::upload($request->file('image'), 'users');
            }

            $user->save();

            if ($request->filled('role_ids')) {
                $user->syncRoles($request->role_ids);
            }

            return $user->load(['userCategory','roles']);
        });
    }

    public function show($id)
    {
        $user = $this->model::with([
            'userCategory:id,name',
            'roles:id,name,display_name',
            'loginHistories',
            'createdBy:id,username',
            'updatedBy:id,username',
        ])->find($id);

        if (!$user) {
            throw new CustomException('User not found');
        }

        return $user;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $user = $this->model::find($id);

            if (!$user) {
                throw new CustomException('User not found');
            }

            $user->user_category_id = $request->user_category_id;
            $user->username         = Str::title($request->username);
            $user->email            = $request->email;
            $user->phone_number     = $request->phone_number;
            $user->status           = $request->status;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $user->img_path = FileUploadHelper::replace($request->file('image'),$user->img_path,'users');
            }

            $user->save();

            if ($request->has('role_ids')) {
                $user->syncRoles($request->role_ids ?? []);
            }

            return $user;
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $user = $this->model::find($id);

            if (!$user) {
                throw new CustomException('User not found');
            }

            $user->deleted_by = Auth::id();
            $user->save();

            $user->delete();

            return true;
        });
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {

            $user = $this->model::onlyTrashed()->find($id);

            if (!$user) {
                throw new CustomException('Deleted user not found');
            }

            $user->deleted_by = NULL;
            $user->save();

            $user->restore();

            return $user->fresh()->load(['userCategory','roles']);
        });
    }

    public function permanentDelete($id)
    {
        return DB::transaction(function () use ($id) {

            $user = $this->model::onlyTrashed()->find($id);

            if (!$user) {
                throw new CustomException('Deleted user not found');
            }

            if ($user->img_path) {
                FileUploadHelper::delete($user->img_path);
            }

            $user->roles()->detach();

            $user->deleted_by = Auth::id();
            $user->save();

            $user->forceDelete();

            return true;
        });
    }
}
