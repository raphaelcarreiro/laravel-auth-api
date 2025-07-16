<?php

namespace Core\Shared\Infra\Messenger\Kafka\Consumers;

use Core\Audit\Application\Dto\AuditConsumerInput;
use Core\Audit\Application\UseCases\AuditConsumerUseCase;
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
    public function __construct(private readonly AuditConsumerUseCase $usecase)
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
        while (true) {
            $message = $this->consumer->consume(10000);

            echo 'consumer state ' . $message->errstr() . $message->err . PHP_EOL;

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
        $payload = $message->payload;

        $this->usecase->execute(new AuditConsumerInput(json_decode($payload, true)));

        $this->logger()->info('audit message processed');
    }
}
