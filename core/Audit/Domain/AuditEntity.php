<?php

namespace Core\Audit\Domain;

use Core\Shared\Domain\Entity;
use Core\User\Domain\UserId;
use DateTime;

class AuditEntity extends Entity
{
    public UserId $id;
    public string $route;
    public DateTime $createdAt;
    public string $input;
    public string $output;

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }

    public static function create(array $payload): Entity
    {
        // TODO: Implement create() method.
    }
}
