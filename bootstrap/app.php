<?php

use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsGuestMiddleware;
use App\Http\Middleware\isOperatorMiddleware;
use App\Http\Middleware\IsUserMiddleware;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schedule;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "is-admin" => IsAdminMiddleware::class,
            "is-user" => IsUserMiddleware::class,
            "is-guest" => IsGuestMiddleware::class,
            "is-operator" => isOperatorMiddleware::class,
            "locale" => LocaleMiddleware::class,
            "abilities" => CheckAbilities::class,
            "ability" =>CheckForAnyAbility::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
