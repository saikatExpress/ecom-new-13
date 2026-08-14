<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Blog\TagController;
use App\Http\Controllers\Backend\Blog\BlogCategoryController;
use App\Http\Controllers\Backend\Blog\BlogController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin/blog-category')->group(function(){
        Route::controller(BlogCategoryController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/tag')->group(function(){
        Route::controller(TagController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/blog')->group(function(){
        Route::controller(BlogController::class)->group(function(){
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
