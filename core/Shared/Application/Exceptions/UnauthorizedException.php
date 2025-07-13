<?php

namespace Core\Shared\Application\Exceptions;

class UnauthorizedException extends HttpException
{
    public function __construct(string $message = 'unauthorized', int $statusCode = 401, array $detail = [])
    {
        parent::__construct($message, $statusCode, $detail);
    }
}
