<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface;

class DatabaseDriver implements StorageDriverInterface
{
    /**
     * @param array $data
     */
    public function store(array $data): void
    {
        ScenarioLog::create(['raw_log' => $data]);
    }
}
