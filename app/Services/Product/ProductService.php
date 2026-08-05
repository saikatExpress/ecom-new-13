<?php

namespace App\Services\Product;

use App\Models\Product\Product;

class ProductService
{
    public function __construct(protected Product $model){}
}
