<?php

return [
    'brokers' => env('KAFKA_BROKERS'),
    'audit_topic' => env('KAFKA_AUDIT_TOPIC', 'audit'),
    'client_id' => env('KAFKA_CLIENT_ID', 'kafka-client'),
    'group_id' => env('KAFKA_GROUP_ID', 'kafka-group'),
];
