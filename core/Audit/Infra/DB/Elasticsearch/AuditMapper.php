<?php

namespace Core\Audit\Infra\DB\Elasticsearch;

use Core\Audit\Domain\AuditEntity;

class AuditMapper
{
    public static function toDocument(AuditEntity $entity): array
    {
        return $entity->toArray();
    }
}
