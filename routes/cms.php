<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CMS\CmsController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/pages')->group(function(){
        Route::controller(CmsController::class)->group(function(){
            Route::get('/{slug}', 'show');
            Route::put('/{slug}', 'updatePage');
        });
    });
});
