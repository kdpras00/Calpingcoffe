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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
        // The following line is added based on the user's instruction.
        // Note: In Laravel, global middleware exclusions are typically defined in Http/Kernel.php
        // or using methods like $middleware->web(except: [...]) or $middleware->api(except: [...]).
        // Adding a protected property directly inside this closure as shown in the instruction
        // is not standard Laravel practice for middleware configuration and might not have the
        // intended effect or could lead to syntax errors depending on its exact placement.
        // However, to faithfully apply the change as requested, it is placed here.
        // If this causes a syntax error or unexpected behavior, please review the intended
        // way to exclude 'payment/notification' from middleware.
        $middleware->validateCsrfTokens(except: [
            'payment/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
