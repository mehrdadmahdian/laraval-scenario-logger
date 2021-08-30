<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers;

interface StorageDriverInterface
{
    public function store(array $data): bool;
}
