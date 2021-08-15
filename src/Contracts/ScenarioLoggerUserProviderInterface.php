<?php

namespace Escherchia\LaravelScenarioLogger\Contracts;

interface ScenarioLoggerUserProviderInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

}
