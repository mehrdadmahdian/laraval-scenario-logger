<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

class LoggerServiceContainer
{
    /**
     * @var array
     */
    private $items = array();

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @param $item
     */
    public function add(string $key, $item): void
    {
        $this->items[$key] = $item;
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }

}
