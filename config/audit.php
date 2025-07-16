<?php

return [
    'topic' => env('KAFKA_AUDIT_TOPIC', 'authapi.audit.created'),
    'index' => env('ELASTICSEARCH_AUDIT_INDEX', 'authapi-audit'),
];
