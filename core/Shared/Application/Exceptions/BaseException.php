<?php

namespace Core\Shared\Application\Exceptions;

use Core\Shared\Infra\Logger\LoggerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\StatusCode;

abstract class BaseException extends Exception
{
    use LoggerTrait;

    abstract function toArray(): array;

    abstract function getStatusCode(): int;

    public function report(): bool
    {
        $span = Span::getCurrent();

        if ($span->isRecording()) {
            $this->recordException($span);
        }

        $this->logger()->error($this->getMessage(), [
            'extra' => [
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'trace' => str_replace("\n", "\\n", $this->getTraceAsString())
            ]
        ]);

        return true;
    }

    private function recordException(SpanInterface $span): void
    {
        $span->recordException($this);
        $span->setAttribute('exception.type', get_class($this));
        $span->setAttribute('exception.message', $this->getMessage());
        $span->setAttribute('exception.code', $this->getCode());
        $span->setAttribute('exception.file', $this->getFile());
        $span->setAttribute('exception.line', $this->getLine());
        $span->setAttribute('http.status_code', $this->getStatusCode());
        $span->setStatus(StatusCode::STATUS_ERROR);
    }

    public function render(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getStatusCode());
    }
}
