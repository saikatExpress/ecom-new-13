<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Order\OrderSourceController;

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
});
