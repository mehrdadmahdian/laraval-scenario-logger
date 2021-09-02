<?php

return [

    'is_active' => true,
    'default-storage-driver' => 'database',

    'drivers' => [
        'database' => [
            'connection' => 'testing',
        ],
    ],

    'active-services' => [
        'log-model-changes',
        'log-request',
        'log-response',
        'log-exception',
        'log-manual-trace',
    ],

    'service-configuration' => [
        'log-model-changes' => [
            'models' => [
            ],
        ],
        'log-response' => [
            'disable-store-content' => false,
        ],
    ],
];
