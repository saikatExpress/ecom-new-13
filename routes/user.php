<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\User\RoleController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Backend\User\PermissionController;
use App\Http\Controllers\Backend\User\UserCategoryController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/user-category')->group(function(){
        Route::controller(UserCategoryController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',     'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/role')->group(function(){
        Route::controller(RoleController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/permission')->group(function(){
        Route::controller(PermissionController::class)->group(function(){
            Route::get('/',        'index');
        });
    });

    Route::prefix('admin/user')->group(function(){
        Route::controller(UserController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });
});
