<?php

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*')
        );

        $exceptions->render(function (CustomException $e) {

            $payload = [
                'success' => false,
                'message' => $e->getMessage(),
            ];

            if (! empty($e->getErrors())) {
                $payload['errors'] = $e->getErrors();
            }

            return response()->json(
                $payload,
                $e->getStatusCode()
            );
        });

        $exceptions->render(function (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);

        });


        $exceptions->render(function (AuthenticationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);

        });

        $exceptions->render(function (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Resource not found.',
            ], 404);

        });

        $exceptions->render(function (QueryException $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Database error occurred.',
            ], 500);

        });

        $exceptions->render(function (HttpExceptionInterface $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'HTTP Error',
            ], $e->getStatusCode());

        });

        $exceptions->render(function (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);

        });
    })->create();
