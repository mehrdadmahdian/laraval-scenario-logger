<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

class LoggerServiceFactory
{
    public static function factory($key)
    {
        if (isset(static::getList()[$key])) {
            $className = static::getList()[$key];
            return new $className();
        } else {
            throw new \Exception('logger service is not found ');
        }
    }

    public static function getList()
    {
        return [
            'log-model-changes'  => LogModelChanges::class
        ];
    }

}
