<?php

namespace App\Modules\Opentelemetry\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use OpenTelemetry\API\Trace\TracerProviderInterface;

readonly class OpentelemetryQueryListener
{
    public function __construct(private TracerProviderInterface $provider) {}

    public function handle(QueryExecuted $event): void
    {
        $tracer = $this->provider->getTracer('mysql');
        $operation = strtoupper(strtok(trim($event->sql), ' ')); // SELECT, INSERT, etc.

        preg_match('/(from|into|update)\s+([a-z0-9_`]+)/i', $event->sql, $matches);
        $table = $matches[2] ?? null;

        $span = $tracer->spanBuilder("DB $operation" . ($table ? " $table" : ''))->startSpan();
        $scope = $span->activate();

        try {
            $span->setAttribute('db.system', 'mysql');
            $span->setAttribute('db.name', $event->connectionName);
            $span->setAttribute('db.statement', $event->sql);
            $span->setAttribute('db.operation', $operation);
            if ($table) {
                $span->setAttribute('db.sql.table', $table);
            }
            $span->setAttribute('db.bindings', json_encode($event->bindings));
            $span->setAttribute('db.duration_ms', $event->time);

            $config = config("database.connections.{$event->connectionName}");
            if ($config) {
                $span->setAttribute('net.peer.name', $config['host'] ?? 'localhost');
                $span->setAttribute('net.peer.port', $config['port'] ?? 3306);
            }

        } finally {
            $span->end();
            $scope->detach();
        }
    }
}
