<?php

namespace Core\Audit\Domain;

use Core\Shared\Domain\Entity;
use Core\User\Domain\UserId;
use DateTime;
use DateTimeInterface;

class AuditEntity extends Entity
{
    public UserId $id;
    public string $route;
    public DateTime $createdAt;
    public string $request;
    public string $response;

    public function __construct(UserId $id, string $request, string $response, string $route, DateTime $createdAt,)
    {
        $this->id = $id;
        $this->route = $route;
        $this->request = $request;
        $this->response = $response;
        $this->createdAt = $createdAt;
    }

    public static function create(array $payload): AuditEntity
    {
        return new self(
            id: new UserId($payload['id']),
            request: $payload['request'],
            response: '',
            route: $payload['route'],
            createdAt: new DateTime()
        );
    }

    public function changeResponse(string $value): void
    {
        $this->response = $value;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'route' => $this->route,
            'created_at' => $this->createdAt->format(DateTimeInterface::ATOM),
            'request' => $this->request,
            'response' => $this->response,
        ];
    }
}
