<?php

namespace App\Http\Controllers\Backend\Order;

use App\Services\Order\PathaoService;
use App\Http\Controllers\BaseController;

class PathaoController extends BaseController
{
    public function __construct(protected PathaoService $service){}

    public function index()
    {
        $result = $this->service->index();

        return $this->sendResponse($result, "Pathao Store List");
    }
}
