<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

class DatabaseDriver implements StorageDriverInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $structured = [
            'raw_log' => $data,
        ];
        ScenarioLog::create($structured);

        return true;
    }
}
