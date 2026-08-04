<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\AttributeService;

class AttributeController extends BaseController
{
    public function __construct(protected AttributeService $service){}
}
