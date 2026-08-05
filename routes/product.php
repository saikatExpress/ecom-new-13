<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\BrandController;
use App\Http\Controllers\Backend\Product\AttributeController;
use App\Http\Controllers\Backend\Product\CategoryController;
use App\Http\Controllers\Backend\Product\SubCategoryController;
use App\Http\Controllers\Backend\Product\AttributeValueController;

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

    Route::prefix('admin/subcategory')->group(function(){
        Route::controller(SubCategoryController::class)->group(function(){
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

    Route::prefix('admin/attribute')->group(function(){
        Route::controller(AttributeController::class)->group(function(){
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

    Route::prefix('admin/attribute-value')->group(function(){
        Route::controller(AttributeValueController::class)->group(function(){
            Route::get('/',                         'index');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
        });
    });
});
