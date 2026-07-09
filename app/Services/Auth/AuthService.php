<?php

namespace App\Services\Auth;

use App\Enums\StatusEnum;
use App\Models\User;
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
}
