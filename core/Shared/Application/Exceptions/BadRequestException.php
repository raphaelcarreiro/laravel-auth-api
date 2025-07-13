<?php

namespace Core\Shared\Application\Exceptions;

class BadRequestException extends HttpException
{
    public function __construct(string $message, int $statusCode = 400, array $detail = [])
    {
        parent::__construct($message, $statusCode, $detail);
    }
}
