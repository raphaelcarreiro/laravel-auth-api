<?php

namespace Core\Audit\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class UpdateAuditInput extends Dto
{
    public string $response;
    public int $status_code;
    public array|null $user;
    public string|null $route_name;
}
