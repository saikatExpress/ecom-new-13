<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\BrandController;
use App\Http\Controllers\Backend\Product\CategoryController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/category')->group(function(){
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'forceDelete');
        });
    });

    Route::prefix('admin/brand')->group(function(){
        Route::controller(BrandController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'forceDelete');
        });
    });
});
