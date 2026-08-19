<?php

namespace App\Http\Resources\Backend\User;

use App\Helpers\File\FileUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'username'       => $this->username,
            'email'          => $this->email,
            'phone_number'   => $this->phone_number,
            'image'          => FileUrlHelper::url($this->img_path),
            'last_login_at'  => $this->last_login_at,
            'last_logout_at' => $this->last_logout_at,
            'status'         => $this->status,
            'user_category' => $this->whenLoaded('userCategory', function () {
                return [
                    'id'   => $this->userCategory->id,
                    'name' => $this->userCategory->name,
                ];
            }),
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->map(function ($role) {
                    return [
                        'id'           => $role->id,
                        'name'         => $role->name,
                        'display_name' => $role->display_name,
                    ];
                });
            }),
            'created_by' => $this->whenLoaded('createdBy', function () {
                return [
                    'id'       => $this->createdBy->id,
                    'username' => $this->createdBy->username,
                ];
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function () {
                return [
                    'id'       => $this->updatedBy->id,
                    'username' => $this->updatedBy->username,
                ];
            }),
            'deleted_by' => $this->whenLoaded('deletedBy', function () {
                return [
                    'id'       => $this->deletedBy->id,
                    'username' => $this->deletedBy->username,
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
