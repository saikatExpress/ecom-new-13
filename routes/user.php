<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\Backend\User\UserController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/user-category')->group(function(){
        Route::controller(UserCategoryController::class)->group(function(){
            Route::get('/',        'index');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/user')->group(function(){
        Route::controller(UserController::class)->group(function(){
            Route::get('/', 'index');
        });
    });
});
