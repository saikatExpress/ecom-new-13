<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Order\StatusController;
use App\Http\Controllers\Backend\Order\CourierController;
use App\Http\Controllers\Backend\Order\OrderSourceController;
use App\Http\Controllers\Backend\Order\CustomerTypeController;
use App\Http\Controllers\Backend\Order\CancelReasonController;
use App\Http\Controllers\Backend\Order\CouponController;
use App\Http\Controllers\Backend\Order\CourierSettingController;
use App\Http\Controllers\Backend\Order\PaymentGatewayController;
use App\Http\Controllers\Backend\Order\DeliveryGatewayController;
use App\Http\Controllers\Backend\Order\DistrictController;
use App\Http\Controllers\Backend\Order\OrderController;
use App\Http\Controllers\Backend\Order\OrderGuardSettingController;
use App\Http\Controllers\Backend\Order\OrderNoteController;

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin/order-source')->group(function(){
        Route::controller(OrderSourceController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/customer-type')->group(function(){
        Route::controller(CustomerTypeController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/note')->group(function(){
        Route::controller(OrderNoteController::class)->group(function(){
            Route::get('/',        'index');
            Route::post('/',       'store');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/district')->group(function(){
        Route::controller(DistrictController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/payment-gateway')->group(function(){
        Route::controller(PaymentGatewayController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::get('/list',                     'list');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'restore');
        });
    });

    Route::prefix('admin/courier')->group(function(){
        Route::controller(CourierController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::get('/list',                     'list');
            Route::post('/',                        'store');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });

    Route::prefix('admin/status')->group(function(){
        Route::controller(StatusController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/trash',                    'trashList');
            Route::get('/list',                     'list');
            Route::post('/',                        'store');
            Route::post('/reorder',                 'reorder');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });

    Route::prefix('admin/coupon')->group(function(){
        Route::controller(CouponController::class)->group(function(){
            Route::get('/',                         'index');
            Route::get('/list',                     'list');
            Route::get('/trash',                    'trashList');
            Route::get('/list',                     'list');
            Route::post('/',                        'store');
            Route::post('/reorder',                 'reorder');
            Route::get('/{id}',                     'show');
            Route::put('/{id}',                     'update');
            Route::delete('/{id}',                  'destroy');
            Route::patch('/{id}/restore',           'restore');
            Route::delete('/permanent-delete/{id}', 'permanentDelete');
        });
    });

    Route::prefix('admin/order-guard-setting')->group(function(){
        Route::controller(OrderGuardSettingController::class)->group(function(){
            Route::get('/', 'show');
            Route::put('/', 'update');
        });
    });

    Route::prefix('admin/courier-setting')->group(function(){
        Route::controller(CourierSettingController::class)->group(function(){
            Route::get('/{slug}', 'show');
            Route::put('/{slug}', 'update');
        });
    });

    Route::prefix('admin/delivery-gateway')->group(function(){
        Route::controller(DeliveryGatewayController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/cancel-reason')->group(function(){
        Route::controller(CancelReasonController::class)->group(function(){
            Route::get('/',        'index');
            Route::get('/list',    'list');
            Route::post('/',       'store');
            Route::get('/{id}',    'show');
            Route::put('/{id}',    'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('admin/order')->group(function(){
        Route::controller(OrderController::class)->group(function(){
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
