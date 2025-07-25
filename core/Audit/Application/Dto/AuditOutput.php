<?php

namespace Core\Audit\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class AuditOutput extends Dto
{
    public string $id;
    public string|null $user_id;
    public string $route;
    public string|null $route_name;
    public string $request;
    public string $response;
    public string $created_at;
    public string $status;
    public string $started_at;
    public string $finished_at;
    public int $duration;
    public string $application_name;
}
