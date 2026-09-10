<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AI\BlogAiController;
use App\Http\Controllers\Backend\AI\Ecommerce\EcommerceAiController;
use App\Http\Controllers\Backend\AI\Product\ProductAiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin/blogs')->group(function(){
        Route::controller(BlogAiController::class)->group(function(){
            Route::post('/ai-generate', 'generate');
        });
    });

    Route::prefix('admin/ai')->group(function(){
        Route::controller(EcommerceAiController::class)->group(function(){
            Route::post('/chat', 'chat');
        });
    });

    Route::prefix('admin/product')->group(function(){
        Route::controller(ProductAiController::class)->group(function(){
            Route::post('/ai-generate', 'generate');
        });
    });
});
