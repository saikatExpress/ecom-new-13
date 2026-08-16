<?php

use App\Http\Controllers\Backend\CMS\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CMS\CmsController;
use App\Http\Controllers\Backend\CMS\FaqController;
use App\Http\Controllers\Backend\CMS\SectionController;
use App\Http\Controllers\Backend\CMS\SliderController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/pages')->group(function(){
        Route::controller(CmsController::class)->group(function(){
            Route::get('/{slug}', 'show');
            Route::put('/{slug}', 'updatePage');
        });
    });

    Route::prefix('admin/faq')->group(function(){
        Route::controller(FaqController::class)->group(function(){
            Route::get('/',        'index');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/slider')->group(function(){
        Route::controller(SliderController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                'trashList');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });

    Route::prefix('admin/section')->group(function(){
        Route::controller(SectionController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/list',                     'list');
            Route::get('/trash',                    'trashList');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });

    Route::prefix('admin/banner')->group(function(){
        Route::controller(BannerController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/list',                     'list');
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
