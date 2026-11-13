<?php

use App\Http\Controllers\Frontend\Blog\BlogCategoryController;
use App\Http\Controllers\Frontend\Blog\BlogController;
use App\Http\Controllers\Frontend\Blog\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CMS\SectionController;
use App\Http\Controllers\Frontend\CMS\SliderController;
use App\Http\Controllers\Frontend\Order\CustomerOrderController;
use App\Http\Controllers\Frontend\Order\DeliveryGatewayController;
use App\Http\Controllers\Frontend\Order\PaymentGatewayController;
use App\Http\Controllers\Frontend\Product\BrandController;
use App\Http\Controllers\Frontend\Product\CategoryController;
use App\Http\Controllers\Frontend\Product\ProductController;

Route::prefix('slider')->group(function(){
    Route::controller(SliderController::class)->group(function(){
        Route::get('/',      'index');
        Route::get('/{id}',  'show');
    });
});

Route::prefix('section')->group(function(){
    Route::controller(SectionController::class)->group(function(){
        Route::get('/',    'index');
    });
});

Route::prefix('category')->group(function(){
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/',    'index');
    });
});

Route::prefix('brand')->group(function(){
    Route::controller(BrandController::class)->group(function(){
        Route::get('/',    'index');
    });
});

// Product
Route::prefix('product')->group(function(){
    Route::controller(ProductController::class)->group(function(){
        Route::get('/',        'index');
        Route::get('/{slug}',  'show');
    });
});

Route::prefix('payment-gateway')->group(function(){
    Route::controller(PaymentGatewayController::class)->group(function(){
        Route::get('/',   'index');
    });
});

Route::prefix('delivery-gateway')->group(function(){
    Route::controller(DeliveryGatewayController::class)->group(function(){
        Route::get('/',   'index');
    });
});

// Orders
Route::prefix('order')->group(function(){
    Route::controller(CustomerOrderController::class)->group(function(){
        Route::post('/',    'store');
        Route::get('/{id}', 'get');
    });
});

// Blog
Route::prefix('blog')->group(function(){
    Route::controller(BlogController::class)->group(function(){
        Route::get('/',       'index');
        Route::get('/{slug}', 'show');
    });
});

Route::prefix('blog-category')->group(function(){
    Route::controller(BlogCategoryController::class)->group(function(){
        Route::get('/', 'index');
    });
});

Route::prefix('tag')->group(function(){
    Route::controller(TagController::class)->group(function(){
        Route::get('/', 'index');
    });
});
