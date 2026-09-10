<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AI\BlogAiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin/blogs')->group(function(){
        Route::controller(BlogAiController::class)->group(function(){
            Route::post('/ai-generate', 'generate');
        });
    });
});
