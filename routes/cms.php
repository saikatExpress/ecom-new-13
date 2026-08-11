<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CMS\CmsController;
use App\Http\Controllers\Backend\CMS\FaqController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/pages')->group(function(){
        Route::controller(CmsController::class)->group(function(){
            Route::get('/{slug}', 'show');
            Route::put('/{slug}', 'updatePage');
        });
    });

    Route::prefix('admin/faq')->group(function(){
        Route::controller(FaqController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});
