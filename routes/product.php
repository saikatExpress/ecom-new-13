<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\BrandController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/brand')->group(function(){
        Route::controller(BrandController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
    });
});
