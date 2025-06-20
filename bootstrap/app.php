<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->replace(
            \Illuminate\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\TrustProxies::class
        );
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'otp.verified' => \App\Http\Middleware\EnsureOtpVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();