<?php

namespace Core\Shared\Infra\Messenger;

use Core\Shared\Infra\Messenger\Kafka\KafkaMessenger;

trait MessengerTrait
{
    public function messenger(): MessengerInterface
    {
        return new KafkaMessenger();
    }
}
