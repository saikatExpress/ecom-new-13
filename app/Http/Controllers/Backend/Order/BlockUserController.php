<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\BlockUserService;
use App\Http\Resources\Backend\Order\BlockUserCollection;

class BlockUserController extends BaseController
{
    public function __construct(protected BlockUserService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(),'block_customer_read', 'You have no permission for read this');

        $blockUsers = $this->service->index($request);

        $blockUsers = new BlockUserCollection($blockUsers);

        return $this->sendResponse($blockUsers, "Block User List");
    }
}
