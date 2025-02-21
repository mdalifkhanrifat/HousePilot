<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    })   
    ->withExceptions(function (Exceptions $exceptions) {
        
        $exceptions->renderable(function (RouteNotFoundException $e, Request $request) 
        {
            if ($request->is('api/*')) 
            {
                Log::error("API Route Not Found", ['exception' => $e]);

                return response()->json([
                    'success' => false,
                    'message' => "Route not found."
                ], 404);
            }
        });

        
        $exceptions->renderable(function (HttpExceptionInterface $e, Request $request) 
        {
            if ($request->is('api/*')) 
            {
                Log::error("HTTP Exception", ['exception' => $e]);

                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?? "Internal Server Error. Please try again later."
                ], $e->getStatusCode() ?? 500);
            }
        });

        
        $exceptions->renderable(function (\Throwable $e, Request $request) 
        {
            if ($request->is('api/*')) 
            {
                
                Log::error("Unhandled Exception", ['exception' => $e]);

                return response()->json([
                    'success' => false,
                    'message' => "Something went wrong. Please try again later."
                ], 500);
            }
        });
    })
    ->create();
