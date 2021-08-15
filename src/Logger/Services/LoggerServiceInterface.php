<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

interface LoggerServiceInterface
{
    /**
     *
     */
    public function boot(): void;

    /**
     * @return array
     */
    public function report(): array;

    /**
     * @param mixed ...$data
     */
    public function log($data):void ;
}
