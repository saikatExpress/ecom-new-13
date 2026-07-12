<?php

use App\Http\Controllers\Backend\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('/login',           'login');
        Route::post('/verify-otp',      'verifyOtp');
        Route::post('/resend-otp',      'resendOtp');
        Route::post('/forgot-password',  'forgotPassword');
        Route::post('/reset-password',   'resetPassword');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function(){
        Route::controller(AuthController::class)->group(function(){
            Route::get('/me', 'me');
            Route::post('/logout',             'logout');
            Route::post('/logout-all-devices', 'logoutAllDevices');
        });
    });
});
