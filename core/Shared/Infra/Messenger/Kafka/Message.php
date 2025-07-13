<?php

namespace Core\Shared\Infra\Messenger\Kafka;

use Core\Shared\Domain\ValueObjects\Uuid;

abstract class Message
{
    protected string $key;
    public readonly mixed $content;
    protected array $headers;
    public string $destination;

    public function __construct()
    {
        $this->key = new Uuid();
        $this->headers = [];
    }

    protected abstract function setKey(string $key): void;

    public function getKey(): string
    {
        return $this->key;
    }

    public function setContent(mixed $content): void
    {
        $this->content = $content;
    }

    protected function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    function toArray(): array
    {
        return [
            'key' => $this->key,
            'content' => $this->content,
            'headers' => $this->headers,
        ];
    }
}
