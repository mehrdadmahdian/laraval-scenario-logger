<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

class LoggerServiceContainer
{
    private $items = array();

    public function all()
    {
        return $this->items;
    }

    public function get($key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    public function add($key, $item): void
    {
        $this->items[$key] = $item;
    }

    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }

}
