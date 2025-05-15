<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'The requested ' . $request->path() . ' was not found.',
                [],
                404
            ]);
        });
        $exceptions->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    $message = 'Los datos proporcionados no son válidos.';
                    $errors = $e->validator->errors()->toArray();
                    $status = $e->status;
                }
                if ($e instanceof NotFoundHttpException) {
                    $message = 'The requested' . $request->path() . ' was not found.';
                    $status = 404;
                }
                return response()->json(
                    [
                        'message' => $message ?? $e->getMessage(),
                        'errors' => $errors ?? [],
                        'status' => $status ?? 500,
                    ],

                );
            }
            return new Response($e->getMessage(), 404);
        });
    })->create();
