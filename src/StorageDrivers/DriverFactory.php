<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers;

use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\DatabaseDriver;

class DriverFactory
{
    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function factory($key)
    {
        if (isset(static::getList()[$key])) {
            $className = static::getList()[$key];

            return new $className();
        } else {
            if (class_exists($key) and class_implements($key, StorageDriverInterface::class)) {
                return new $key;
            } else {
                throw new \Exception('storage driver could not be construced.');
            }
        }
    }

    /**
     * @return string[]
     */
    public static function getList()
    {
        return [
            'database'  => DatabaseDriver::class,
        ];
    }
}
