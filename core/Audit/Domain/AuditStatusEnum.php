<?php

namespace Core\Audit\Domain;

enum AuditStatusEnum: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
