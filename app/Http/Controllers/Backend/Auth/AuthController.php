<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Auth\StoreUserRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService){}
    public function register(StoreUserRequest $request)
    {
        $user = $this->authService->register($request);
        return $this->sendResponse($user, 'User registered successfully');
    }

    public function login(Request $request)
    {
        return $request;
    }
}
