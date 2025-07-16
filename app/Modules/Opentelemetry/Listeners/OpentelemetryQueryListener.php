<?php

namespace App\Modules\Opentelemetry\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;

readonly class OpentelemetryQueryListener
{
    private string $operation;
    private string $table;
    private SpanInterface $span;

    public function __construct(private TracerProviderInterface $provider) {}

    public function handle(QueryExecuted $event): void
    {
        $this->initialize($event);
        $this->startSpan();

        $scope = $this->span->activate();

        try {
            $this->tryInstrumentation($event);
        } finally {
            $this->span->end();
            $scope->detach();
        }
    }

    private function initialize(QueryExecuted $event): void
    {
        $this->operation = strtoupper(strtok(trim($event->sql), ' '));

        preg_match('/(from|into|update)\s+([a-z0-9_`]+)/i', $event->sql, $matches);
        $this->table = $matches[2] ?? null;
    }

    private function startSpan(): void
    {
        $tracer = $this->provider->getTracer('mysql');

        $this->span = $tracer->spanBuilder(
            "DB $this->operation" . ($this->table ? " $this->table" : '')
        )->startSpan();
    }

    private function tryInstrumentation(QueryExecuted $event): void
    {
        $this->span->setAttribute('db.system', 'mysql');
        $this->span->setAttribute('db.name', $event->connectionName);
        $this->span->setAttribute('db.statement', $event->sql);
        $this->span->setAttribute('db.operation', $this->operation);

        if ($this->table) {
            $this->span->setAttribute('db.sql.table', $this->table);
        }

        $this->span->setAttribute('db.bindings', json_encode($event->bindings));
        $this->span->setAttribute('db.duration_ms', $event->time);

        $config = config("database.connections.{$event->connectionName}");

        if ($config) {
            $this->span->setAttribute('net.peer.name', $config['host'] ?? 'localhost');
            $this->span->setAttribute('net.peer.port', $config['port'] ?? 3306);
        }
    }
}
