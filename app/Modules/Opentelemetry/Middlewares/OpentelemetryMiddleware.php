<?php

namespace App\Modules\Opentelemetry\Middlewares;

use Closure;
use Illuminate\Http\Request;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\ScopeInterface;
use Throwable;

readonly class OpentelemetryMiddleware
{
    public function __construct(private TracerProviderInterface $provider) {}

    /**
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        $tracer = $this->provider->getTracer('http-server');
        $span = $tracer->spanBuilder("HTTP {$request->method()} {$request->path()}")->startSpan();
        $scope = $span->activate();

        try {
            return $this->tryInstrumentation($request, $next, $span);
        } catch (Throwable $e) {
            $this->onError($e, $span);
        } finally {
            $this->onFinally($span, $scope);
        }
    }

    private function tryInstrumentation(Request $request, Closure $next, SpanInterface $span)
    {
        $response = $next($request);

        $span->setAttribute('http.method', $request->method());
        $span->setAttribute('http.route', $request->path());
        $span->setAttribute('http.status_code', $response->getStatusCode());
        $span->setAttribute('http.target', $request->path());
        $span->setAttribute('http.url', $request->fullUrl());

        return $response;
    }

    /**
     * @throws Throwable
     */
    private function onError(Throwable $e, SpanInterface $span): void
    {
        $span->recordException($e);
        $span->setStatus(StatusCode::STATUS_ERROR);
        throw $e;
    }

    private function onFinally(SpanInterface $span, ScopeInterface $scope): void
    {
        $span->end();
        $scope->detach();
    }
}
