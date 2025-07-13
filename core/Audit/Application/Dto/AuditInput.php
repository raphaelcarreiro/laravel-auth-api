<?php

namespace Core\Audit\Application\Dto;

use Core\Shared\Application\Dto\Dto;
use Core\User\Domain\UserId;

class AuditInput extends Dto
{
    public string $request;
    public UserId|null $userId;
    public string $route;
}
