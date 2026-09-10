<?php

use App\Http\Controllers\Backend\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/setting')->group(function() {
        Route::controller(SettingController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
    });
});
