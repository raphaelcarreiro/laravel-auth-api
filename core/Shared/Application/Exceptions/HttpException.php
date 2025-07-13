<?php

namespace Core\Shared\Application\Exceptions;

class HttpException extends BaseException
{
    public function __construct(string $message, public readonly int $statusCode, public readonly array $detail = []
    ) {
        parent::__construct($message);
    }

    function toArray(): array
    {
        return [
            'status_code' => $this->statusCode,
            'message' => $this->message,
            'detail' => $this->detail,
        ];
    }

    function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
