<?php

namespace Core\Shared\Infra\Messenger\Kafka\Consumers;

use Core\Shared\Infra\Logger\LoggerTrait;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\KafkaConsumer;
use RdKafka\Message;

class AuditConsumer
{
    use LoggerTrait;

    private KafkaConsumer $consumer;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', config('kafka.brokers'));
        $conf->set('group.id', config('kafka.group_id', 'audit-consumer'));
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('auto.commit.interval.ms', '1000');
        $conf->set('enable.auto.commit', 'true');

        $this->consumer = new KafkaConsumer($conf);
        $this->consumer->subscribe(['authapi.audit.created']);
    }

    public function listen(): void
    {
        echo "Kafka AuditConsumer started...\n";

        while (true) {
            $message = $this->consumer->consume(10000);

            var_dump($message->errstr());

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $this->process($message);
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    break;
                default:
                    $this->logger()->error($message->errstr());
            }
        }
    }

    private function process(Message $message): void
    {
        $payload = $message->payload ?? '';
        $key = $message->key;

        $data = json_decode($payload, true) ?? ['raw' => $payload];

        $this->logger()->info('Kafka message consumed', [
            'extra' => [
                'key' => $key,
                'partition' => $message->partition,
                'offset' => $message->offset,
                'data' => $data,
            ],
        ]);
    }
}
