<?php

namespace Core\Shared\Infra\Messenger\Kafka;

use Core\Shared\Infra\Messenger\MessengerInterface;

trait MessengerTrait
{
    public function messenger(): MessengerInterface
    {
        return new KafkaMessenger();
    }
}
