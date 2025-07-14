<?php

namespace Core\Audit\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class AuditOutput extends Dto
{
    public string $id;
    public string $user_id;
    public string $route;
    public string|null $route_name;
    public string $request;
    public string $response;
    public string $created_at;
    public string $status;
}
