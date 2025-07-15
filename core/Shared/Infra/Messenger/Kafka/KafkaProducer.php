<?php

namespace Core\Shared\Infra\Messenger\Kafka;

use RdKafka\Conf;
use RdKafka\Producer;

class KafkaProducer
{
    use KafkaInstrumentationTrait;
    private Producer $producer;

    public function __construct()
    {
        $brokers = config('kafka.brokers');

        $conf = new Conf();
        $conf->set('metadata.broker.list', $brokers);

        $this->producer = new Producer($conf);
    }

    public function produce(Message $message): void
    {
        $topic = $this->producer->newTopic($message->destination);

        $topic->produce(
            RD_KAFKA_PARTITION_UA,
            0,
            json_encode($message->content),
            $message->getKey()
        );

        $this->producer->flush(10000);
    }
}
