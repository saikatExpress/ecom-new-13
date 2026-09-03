<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/dashboard')->group(function(){
        Route::controller(DashboardController::class)->group(function() {
            Route::get('/', 'index');
        });
    });

    Route::prefix('admin/cache-clear')->group(function() {
        Route::controller(DashboardController::class)->group(function() {
            Route::post('/', 'clearCache');
        });
    });
});
