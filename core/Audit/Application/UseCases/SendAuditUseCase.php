<?php

namespace Core\Audit\Application\UseCases;

use Core\Audit\Application\Dto\AuditOutput;
use Core\Shared\Infra\Messenger\Kafka\Message;
use Core\Shared\Infra\Messenger\MessengerInterface;

readonly class SendAuditUseCase
{
    public function __construct(private MessengerInterface $messenger)
    {
    }

    public function execute(AuditOutput $audit): void
    {
        $message = $this->buildMessage($audit);
        $this->messenger->send($message);
    }

    private function buildMessage(AuditOutput $audit): Message
    {
        $message = new AuditMessage();
        $message->setKey($audit->id);
        $message->setContent($audit->toArray());

        return $message;
    }
}
