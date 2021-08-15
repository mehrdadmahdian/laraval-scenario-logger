<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

class LogManualTrace implements LoggerServiceInterface
{
    /**
     * @var array
     */
    private $trace = [];

    public function boot(): void
    {
    }

    /**
     * @return array
     */
    public function report(): array
    {
        $data =  $this->trace;
        foreach ($data as $key => $datum) {
            if (is_null($datum) or (is_array($datum) and count($datum) == 0)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     */
    public function log($data): void
    {
        $this->trace[] = $data;
    }

    /**
     * @param string $message
     * @param array $data
     * @param string|null $triggeringFile
     * @param string|null $triggeringMethod
     * @param string|null $triggeringLine
     */
    public function manualLog(
        string $message,
        array $data = array(),
        string $triggeringFile = null,
        string $triggeringMethod = null,
        string $triggeringLine = null
    ) {
        $this->trace [] = [
            'message' => $message,
            'data'    => $data,
            'location' => [
                'file'      => $triggeringFile,
                'method'    => $triggeringMethod,
                'line'      => $triggeringLine,
            ],
        ];
    }
}
