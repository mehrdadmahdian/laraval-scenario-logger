<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ScenarioLog extends Model
{
    /**
     * @var string[]
     */
    public $guarded = ['id'];
    /**
     * @var string[]
     */
    public $casts = [
        'raw_log' => 'array',
        'generic_info' => 'array',
        'log_model_changes' => 'array',
        'log_request' => 'array',
        'log_response' => 'array',
        'log_exception' => 'array',
        'log_manual_trace' => 'array',
    ];

    /**
     * Get the current connection name for the model.
     *
     * @return string|null
     */
    public function getConnectionName(): ?string
    {
        if (
            Config::has('laravel-scenario-logger.storage-driver-configuration.database.connection') &&
            Config::get('laravel-scenario-logger.storage-driver-configuration.database.connection') !== null) {
            return Config::get('laravel-scenario-logger.storage-driver-configuration.database.connection');
        }

        return parent::getConnectionName();
    }
}
