<?php

namespace Core\Shared\Application\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class BaseException extends Exception
{
    abstract function toArray(): array;

    abstract function getStatusCode(): int;

    public function report(): bool
    {
        return true;
    }

    public function render(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getStatusCode());
    }
}
