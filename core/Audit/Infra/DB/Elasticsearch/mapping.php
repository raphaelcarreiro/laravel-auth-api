<?php

namespace Core\Audit\Infra\DB\Elasticsearch;

return [
    'id' => [
        'type' => 'keyword',
    ],
    'created_at' => [
        'type' => 'date',
    ],
    'route' => [
        'type' => 'keyword',
    ],
    'route_name' => [
        'type' => 'keyword',
    ],
    'request' => [
        'type' => 'text',
    ],
    'response' => [
        'type' => 'text',
    ],
    'status' => [
        'type' => 'keyword',
    ],
    'user_id' => [
        'type' => 'keyword',
    ],
    'started_at' => [
        'type' => 'date',
    ],
    'finished_at' => [
        'type' => 'date',
    ],
    'duration' => [
        'type' => 'integer',
    ],
];
