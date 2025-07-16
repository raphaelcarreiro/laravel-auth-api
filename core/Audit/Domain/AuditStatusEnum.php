<?php

namespace Core\Audit\Application\Enums;

enum AuditStatusEnum: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
