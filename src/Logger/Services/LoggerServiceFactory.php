<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

class LoggerServiceFactory
{
    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public static function factory(string $key)
    {
        if (isset(static::getList()[$key])) {
            $className = static::getList()[$key];

            return new $className();
        } else {
            throw new \Exception('logger service is not found ');
        }
    }

    /**
     * @return array|string[]
     */
    public static function getList(): array
    {
        return [
            'log-model-changes'  => LogModelChanges::class,
            'log-request'        => LogRequest::class,
            'log-response'       => LogResponse::class,
            'log-exception'       => LogException::class,
            'log-manual-trace'   => LogManualTrace::class,
        ];
    }
}
