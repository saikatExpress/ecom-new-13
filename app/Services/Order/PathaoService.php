<?php

namespace App\Services\Order;

use App\Helpers\Order\PathaoHelper;

class PathaoService
{
    public function __construct(protected PathaoHelper $helper){}

    public function index()
    {
        $result = $this->helper->getStores();

        return $result;
    }
}
