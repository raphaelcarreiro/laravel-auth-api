<?php

use App\Modules\Audit\Middlewares\AuditMiddleware;
use App\Modules\Opentelemetry\Middlewares\OpentelemetryMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Modules\Audit\Commands\AuditConsumerCommand;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
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

        $exceptions->renderable(function (Throwable $e, Request $request) {
            if (!app()->environment('production')) {
                return null;
            }

            Log::error($e->getMessage(), [
                'extra' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => collect($e->getTrace())->take(5),
                ]
            ]);

            return response()->json([
                'status_code' => 500,
                'message' => 'internal server error'
            ], 500);
        });
    })
    ->withCommands([
        AuditConsumerCommand::class,
    ])
    ->create();
