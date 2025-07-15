<?php

namespace Core\Shared\Infra\Messenger\Kafka;

use Core\Shared\Infra\Messenger\Kafka\Producer\KafkaProducer;
use Core\Shared\Infra\Messenger\MessengerInterface;

class KafkaMessenger implements MessengerInterface
{
    public function send(Message $message): void
    {
        $producer = new KafkaProducer();
        $producer->produceWithInstrumentation($message);
    }

    public function sendMany(array $messages): void
    {
        // TODO: Implement sendMany() method.
    }
}
