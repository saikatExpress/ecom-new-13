<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function __construct(protected UserService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'user_read', 'You have no permission for read this');


    }
}
