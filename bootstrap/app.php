<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LocaleMiddleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Auth\Middleware\AuthenticateSession;
use App\Http\Controllers\SettingController; // Explicitly import SettingController

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // Ensure API routes are also loaded
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            LocaleMiddleware::class, // Keep your custom middleware
        ]);

        $middleware->api([
            // EnsureFrontendRequestsAreStateful::class, // Often used for SPAs with cookie-based auth. Keep if needed.
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'auth.sanctum' => \Laravel\Sanctum\Http\Middleware\AuthenticateWithSanctum::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([
            //
        ]);

        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                // This will handle exceptions for API routes and return JSON
                return response()->json(['message' => $e->getMessage()], $e instanceof \Illuminate\Validation\ValidationException ? 422 : 500);
            } elseif ($request->expectsJson() && $e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
        });
    })->create();
