<?php

use App\Http\Controllers\Frontend\Blog\BlogCategoryController;
use App\Http\Controllers\Frontend\Blog\BlogController;
use App\Http\Controllers\Frontend\Blog\TagController;
use App\Http\Controllers\Frontend\CMS\CmsController;
use App\Http\Controllers\Frontend\CMS\FaqController;
use App\Http\Controllers\Frontend\CMS\SectionController;
use App\Http\Controllers\Frontend\CMS\SliderController;
use App\Http\Controllers\Frontend\Order\CouponController;
use App\Http\Controllers\Frontend\Order\CustomerOrderController;
use App\Http\Controllers\Frontend\Order\DeliveryGatewayController;
use App\Http\Controllers\Frontend\Order\OrderGuardSettingController;
use App\Http\Controllers\Frontend\Order\PaymentGatewayController;
use App\Http\Controllers\Frontend\Product\BrandController;
use App\Http\Controllers\Frontend\Product\CategoryController;
use App\Http\Controllers\Frontend\Product\ProductController;
use App\Http\Controllers\Frontend\Setting\SettingController;
use Illuminate\Support\Facades\Route;

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
        Route::get('/search',  'search');
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

Route::prefix('order/guard')->group(function(){
    Route::controller(OrderGuardSettingController::class)->group(function(){
        Route::get('/', 'show');
    });
});

// Orders
Route::prefix('order')->group(function(){
    Route::controller(CustomerOrderController::class)->group(function(){
        Route::post('/',    'store');
        Route::get('/{id}', 'show');
    });
});

Route::prefix('coupon')->group(function () {
    Route::controller(CouponController::class)->group(function () {
        Route::post('/', 'apply');
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

// CMS
Route::prefix('pages')->group(function(){
    Route::controller(CmsController::class)->group(function(){
        Route::get('/{slug}', 'show');
    });
});

Route::prefix('faq')->group(function(){
    Route::controller(FaqController::class)->group(function(){
        Route::get('/',        'index');
    });
});

// Setting
Route::prefix('settings')->group(function(){
    Route::controller(SettingController::class)->group(function(){
        Route::get('/', 'index');
    });
});
