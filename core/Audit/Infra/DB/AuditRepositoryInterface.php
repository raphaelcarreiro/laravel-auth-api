<?php

namespace Core\Audit\Infra\DB;

use Core\Audit\Domain\AuditEntity;

interface AuditRepositoryInterface
{
    public function save(AuditEntity $audit): void;
}
