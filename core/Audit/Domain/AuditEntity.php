<?php

namespace Core\Audit\Domain;

use Core\Shared\Domain\Entity;
use Core\User\Domain\UserId;
use DateTime;
use DateTimeInterface;

class AuditEntity extends Entity
{
    public AuditId $id;
    public UserId|null $userId;
    public string $route;
    public string|null $routeName;
    public DateTime $createdAt;
    public string $request;
    public string $response;
    public AuditStatusEnum $status;

    public function __construct(
        AuditId $id,
        ?UserId $userId,
        string $request,
        string $response,
        string $route,
        ?string $routeName,
        AuditStatusEnum $status,
        DateTime $createdAt
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->route = $route;
        $this->routeName = $routeName;
        $this->status = $status;
        $this->request = $request;
        $this->response = $response;
        $this->createdAt = $createdAt;
    }

    public static function create(array $payload): AuditEntity
    {
        return new self(
            id: new AuditId(),
            userId: $payload['user_id'] ? new UserId($payload['user_id']) : null,
            request: $payload['request'],
            response: '',
            route: $payload['route'],
            routeName: null,
            status: AuditStatusEnum::SUCCESS,
            createdAt: new DateTime()
        );
    }

    public function changeResponse(string $value): void
    {
        $this->response = $value;
    }

    public function changeUserId(UserId $id): void
    {
        $this->userId = $id;
    }

    public function changeStatus(AuditStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function changeRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'user_id' => $this->userId?->getValue() ?? null,
            'route' => $this->route,
            'route_name' => $this->routeName,
            'created_at' => $this->createdAt->format(DateTimeInterface::ATOM),
            'request' => $this->request,
            'response' => $this->response,
            'status' => $this->status->value,
        ];
    }
}
