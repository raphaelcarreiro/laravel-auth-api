<?php

namespace Core\Shared\Application\Exceptions;

class NotFoundException extends HttpException
{
    public function __construct(string $message, int $statusCode = 404, array $detail = [])
    {
        parent::__construct($statusCode, $message, $detail);
    }
}
