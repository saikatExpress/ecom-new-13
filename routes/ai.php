<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AI\Blog\BlogAiController;
use App\Http\Controllers\Backend\AI\Product\ProductAiController;
use App\Http\Controllers\Backend\AI\Provider\AiProviderController;
use App\Http\Controllers\Backend\AI\Ecommerce\EcommerceAiController;

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

    Route::prefix('admin/provider')->group(function(){
        Route::controller(AiProviderController::class)->group(function(){
            Route::get('/',        'index');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});
