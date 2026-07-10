<?php

namespace App\Http\Resources\Backend\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $role = $this->roles->first();

        return [

            'id' => $this->id,

            'username' => $this->username,

            'email' => $this->email,

            'phone_number' => $this->phone_number,

            'image' => $this->img_path,

            'status' => $this->status,

            'token' => $this->access_token,

            'role' => [
                'id' => optional($role)->id,
                'name' => optional($role)->name,
                'display_name' => optional($role)->display_name,
            ],

            'permissions' => $this->roles
                ->flatMap(fn ($role) => $role->permissions)
                ->unique('id')
                ->values()
                ->map(function ($permission) {

                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'module' => $permission->module,
                        'action' => $permission->action,
                    ];
                }),

        ];
    }
}
