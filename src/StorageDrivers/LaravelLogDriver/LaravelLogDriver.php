<?php 

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\LaravelLogDriver;

use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface;
use Illuminate\Support\Facades\Log;

class LaravelLogDriver implements StorageDriverInterface
{
    public function store(array $data): bool
    {
        $level = 'info';
        $message = 'laravel_log';
        $channel = config('laravel-scenario-logger.drivers.laravel-log.channel', null);
        Log::channel($channel)->write($level, $message, $data);

        return true;
    }
}