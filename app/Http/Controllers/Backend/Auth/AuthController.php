<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Resources\Backend\Auth\AuthResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Auth\LoginRequest;
use App\Http\Requests\Backend\Auth\StoreUserRequest;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService){}
    public function register(StoreUserRequest $request)
    {
        $user = $this->authService->register($request);
        return $this->sendResponse($user, 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request);

        $user = new AuthResource($user);

        return $this->sendResponse($user, 'Login Successfully', 200);
    }
}
