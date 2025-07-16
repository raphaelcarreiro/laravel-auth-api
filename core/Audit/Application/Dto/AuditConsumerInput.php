<?php

namespace Core\Audit\Application\Dto;

use Core\Audit\Domain\AuditStatusEnum;
use Core\Shared\Application\Dto\Dto;

class AuditConsumerInput extends Dto
{
    public string $id;
    public string|null $user_id;
    public string $route;
    public string|null $route_name;
    public string $request;
    public string $response;
    public AuditStatusEnum $status;
    public string $created_at;
    public string $started_at;
    public string $finished_at;
    public int $duration;
}
