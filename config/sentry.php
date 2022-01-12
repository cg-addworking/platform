<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'send_default_pii' => true,
    'breadcrumbs' => [
        // Capture Laravel logs. Defaults to `true`.
        'logs' => true,

        // Capture queue job information. Defaults to `true`.
        'queue_info' => true,

        // Capture SQL queries. Defaults to `true`.
        'sql_queries' => true,

        // Capture bindings (parameters) on SQL queries. Defaults to `false`.
        'sql_bindings' => true,

        'capture_silenced_errors' => true,

        'traces_sample_rate' => 1.0
    ],
];
