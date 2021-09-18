<?php

return [

    'is_active' => true,
    'default-driver' => 'database',

    'drivers' => [
        'database' => [
            'connection' => 'testing',
        ],
        'laravel-log' => [
            'channel' => 'single',
        ]
    ],

    'service-configuration' => [
        'log-response' => [
            'active' => true,
            'class' => LogResponse::class,
            'disable-store-content' => false,
        ],
        'log-request' => [
            'active' => true,
            'class' => LogRequest::class,
        ],
        'log-exception' => [
            'active' => true,
            'class' => LogException::class,
        ],
        'log-manual-trace' => [
            'active' => true,
            'class' => LogManualTrace::class,
        ],
    ],
];
