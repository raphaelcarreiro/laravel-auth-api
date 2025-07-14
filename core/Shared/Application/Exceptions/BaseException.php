<?php

namespace Core\Shared\Application\Exceptions;

use Core\Shared\Infra\Logger\LoggerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

abstract class BaseException extends Exception
{
    use LoggerTrait;

    abstract function toArray(): array;

    abstract function getStatusCode(): int;

    public function report(): bool
    {
        $this->logger()->error($this->getMessage(), [
            'extra' => [
                'code' => $this->getCode(),
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'trace' => $this->getTraceAsString(),
            ]
        ]);

        return true;
    }

    public function render(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getStatusCode());
    }
}
