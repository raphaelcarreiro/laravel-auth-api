<?php

namespace App\Modules\Audit\Commands;

use Core\Shared\Infra\Messenger\Kafka\Consumers\AuditConsumer;
use Illuminate\Console\Command;

class AuditConsumerCommand extends Command
{
    protected $signature = 'kafka:consume-audit';
    protected $description = 'Consume audit messages from Kafka topic';

    public function handle(AuditConsumer $consumer): int
    {
        $consumer->listen();
        return 0;
    }
}
