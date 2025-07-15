<?php

use App\Modules\Audit\Middlewares\AuditMiddleware;
use App\Modules\Opentelemetry\Middlewares\OpentelemetryMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Modules\Audit\Commands\AuditConsumerCommand;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(AuditMiddleware::class);
        $middleware->append(OpentelemetryMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return true;
        });
    })
    ->withCommands([
        AuditConsumerCommand::class,
    ])
    ->create();
