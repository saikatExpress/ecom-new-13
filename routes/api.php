<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CMS\SliderController;
use App\Http\Controllers\Frontend\Order\CustomerOrderController;

Route::prefix('slider')->group(function(){
    Route::controller(SliderController::class)->group(function(){
        Route::get('/',      'index');
        Route::get('/{id}',  'show');
    });

    // Orders
    Route::prefix('order')->group(function(){
        Route::controller(CustomerOrderController::class)->group(function(){
            Route::post('/',    'store');
            Route::get('/{id}', 'get');
        });
    });
});
