<?php

namespace Core\Audit\Application\UseCases;

use Core\Audit\Application\Dto\AuditOutput;
use Core\Shared\Infra\Messenger\Kafka\Message;

class AuditMessageBuilder
{
    public function build(AuditOutput $audit): Message
    {
        $message = new AuditMessage();

        $message->setKey($audit->id);
        $message->setContent($audit->toArray());

        return $message;
    }
}
