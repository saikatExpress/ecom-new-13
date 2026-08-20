<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Order\OrderSourceController;
use App\Http\Controllers\Backend\Order\CustomerTypeController;
use App\Http\Controllers\Backend\Order\DeliveryGatewayController;
use App\Http\Controllers\Backend\Order\PaymentGatewayController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/order-source')->group(function(){
        Route::controller(OrderSourceController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/customer-type')->group(function(){
        Route::controller(CustomerTypeController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/payment-gateway')->group(function(){
        Route::controller(PaymentGatewayController::class)->group(function(){
            Route::get('/',                        'index');
            Route::get('/trash',                   'trashList');
            Route::get('/list',                    'list');
            Route::post('/',                       'store');
            Route::get('/{id}',                    'show');
            Route::put('/{id}',                    'update');
            Route::delete('/{id}',                 'destroy');
            Route::patch('/{id}/restore',          'restore');
            Route::delete('/permanentDelete/{id}', 'restore');
        });
    });

    Route::prefix('admin/delivery-gateway')->group(function(){
        Route::controller(DeliveryGatewayController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});
