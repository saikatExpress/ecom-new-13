<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CMS\SliderController;

Route::prefix('slider')->group(function(){
    Route::controller(SliderController::class)->group(function(){
        Route::get('/',      'index');
        Route::get('/{id}',  'show');
    });
});
