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
            $driverKey = Config::has('laravel-scenario-logger.default-storage-driver') ? Config::get('laravel-scenario-logger.default-storage-driver') : 'database';
        }

        $this->driver = DriverFactory::factory($driverKey);
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        $this->driver->store($data);
    }
}
