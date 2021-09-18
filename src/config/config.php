<?php

use Escherchia\LaravelScenarioLogger\Logger\Services\LogException;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogManualTrace;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogModelChanges;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogRequest;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogResponse;

return [

    'is_active' => true,
    'default' => 'database',

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
        'log-model-changes' => [
            'active' => true,
            'class' => LogModelChanges::class,
            'models' => [
                // model goes here
            ],
        ],
    ],
];
