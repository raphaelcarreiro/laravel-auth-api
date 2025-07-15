<?php

namespace Core\Shared\Infra\Messenger\Kafka\Producer;

use Core\Shared\Infra\Messenger\Kafka\Message;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;

trait KafkaInstrumentationTrait
{
    public function produceWithInstrumentation(Message $message): void
    {
        $tracer = app(TracerProviderInterface::class)->getTracer('kafka-producer');

        $span = $tracer->spanBuilder("kafka.produce.{$message->destination}")->startSpan();
        $scope = $span->activate();

        try {
            $this->tryInstrumentation($message, $span);
        } finally {
            $span->end();
            $scope->detach();
        }
    }

    private function tryInstrumentation(Message $message, SpanInterface $span): void
    {
        $span->setAttribute('messaging.system', 'kafka');
        $span->setAttribute('messaging.destination', $message->destination);
        $span->setAttribute('messaging.destination_kind', 'topic');
        $span->setAttribute('messaging.kafka.client_id', config('kafka.client_id', 'unknown'));

        if ($message->getKey()) {
            $span->setAttribute('messaging.kafka.message_key', $message->getKey());
        }

        $this->produce($message);
    }
}
