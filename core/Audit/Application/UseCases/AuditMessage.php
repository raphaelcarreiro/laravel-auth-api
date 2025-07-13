<?php

namespace Core\Audit\Application\UseCases;

use Core\Shared\Infra\Messenger\Kafka\Message;

class AuditMessage extends Message
{
    public function __construct()
    {
        parent::__construct();
        $this->destination = config('kafka.audit_topic');
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }
}
