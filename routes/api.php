<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CMS\SectionController;
use App\Http\Controllers\Frontend\CMS\SliderController;
use App\Http\Controllers\Frontend\Order\CustomerOrderController;
use App\Http\Controllers\Frontend\Product\BrandController;
use App\Http\Controllers\Frontend\Product\CategoryController;

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

// Orders
Route::prefix('order')->group(function(){
    Route::controller(CustomerOrderController::class)->group(function(){
        Route::post('/',    'store');
        Route::get('/{id}', 'get');
    });
});
