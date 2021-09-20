<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers;

use Illuminate\Support\Facades\Config;

class StorageService
{
    /**
     * @var StorageDriverInterface
     */
    private $driver;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setDriver();
    }

    /**
     * @param null $driverKey
     * @throws \Exception
     */
    public function setDriver($driverKey = null)
    {
        if (!$driverKey) {
            $driverKey = Config::get('laravel-scenario-logger.default_storage_driver', 'database');
        }

        $this->driver = DriverFactory::factory($driverKey);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        return $this->driver->store($data);
    }
}
