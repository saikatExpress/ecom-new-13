<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private User $model){}
    public function register($request)
    {
        $user = new $this->model();

        $user->username     = $request->username;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password     = Hash::make($request->password);
        $user->status       = StatusEnum::ACTIVE->value;
        $user->save();

        return $user;
    }

    public function login($request)
    {
        $user = User::query()
        ->with([
            'roles.permissions'
        ])
        ->where('phone_number', $request->phone_number)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new CustomException('Phone number or password is incorrect.');
        }
    }
}
