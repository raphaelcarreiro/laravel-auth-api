<?php

namespace Core\Shared\Infra\Messenger;

use Core\Shared\Infra\Messenger\Kafka\Message;

interface MessengerInterface
{
    public function send(Message $message): void;

    public function sendMany(array $messages): void;
}
