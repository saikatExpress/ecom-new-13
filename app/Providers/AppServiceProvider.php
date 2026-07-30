<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {

            $phone = $request->input('phone_number', '');

            return Limit::perMinutes(30, 5)
                ->by($request->ip().'|'.$phone)
                ->response(function () {

                    return response()->json([
                        'success' => false,
                        'message' => 'Too many login attempts. Please try again after 30 minutes.'
                    ], 429);

                });

        });

        Blueprint::macro('userstamps', function () {
            $this->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $this->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $this->foreignId('deleted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }
}
