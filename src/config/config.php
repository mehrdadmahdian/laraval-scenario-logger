<?php

use Escherchia\LaravelScenarioLogger\Logger\Services\LogException;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogManualTrace;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogModelChanges;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogRequest;
use Escherchia\LaravelScenarioLogger\Logger\Services\LogResponse;

return [

    'is_active' => true,
    'default_storage_driver' => 'database',

    'storage_drivers' => [
        'database' => [
            'connection' => 'normal',
        ],
        'laravel_log' => [
            'channel' => 'single',
        ]
    ],

    'service_configuration' => [
        'log_response' => [
            'active' => true,
            'class' => LogResponse::class,
            'disable-store-content' => false,
        ],
        'log_request' => [
            'active' => true,
            'class' => LogRequest::class,
        ],
        'log_exception' => [
            'active' => true,
            'class' => LogException::class,
        ],
        'log_manual_trace' => [
            'active' => true,
            'class' => LogManualTrace::class,
        ],
        'log_model_changes' => [
            'active' => true,
            'class' => LogModelChanges::class,
            'models' => [
                // model goes here
            ],
        ],
    ],
];
