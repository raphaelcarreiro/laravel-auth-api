<?php

namespace Core\Shared\Infra\Logger\Laravel;

use Core\Shared\Infra\Logger\LoggerInterface;
use Illuminate\Support\Facades\Log;

class Logger implements LoggerInterface
{
    public function info(string $message, array $context = []): void
    {
        Log::info(...func_get_args());
    }

    public function error(string $message, array $context = []): void
    {
        Log::error(...func_get_args());
    }

    public function warning(string $message, array $context = []): void
    {
        Log::warning(...func_get_args());
    }
}
