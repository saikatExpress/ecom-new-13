<?php

namespace App\Http\Resources\Backend\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'username' => $this->username,

            'email' => $this->email,

            'phone_number' => $this->phone_number,

            'image' => $this->img_path,

            'status' => $this->status,

            'token' => $this->access_token,

            'roles' => $this->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                ];
            })->values(),

            'permissions' => $this->allPermissions()->pluck('name')->values(),
        ];
    }
}
