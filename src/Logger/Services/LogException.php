<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

class LogException implements LoggerServiceInterface
{
    /**
     * @var array|\Throwable
     */
    private $throwable;

    /**
     *
     */
    public function boot(): void
    {
    }

    /**
     * @return array
     */
    public function report(): array
    {
        if ($this->throwable) {
            return [
                'message' => $this->throwable->getMessage(),
                'trace' => $this->throwable->getTraceAsString(),
            ];
        } else {
            return [];
        }
    }

    /**
     * @param mixed $data
     */
    public function log($data): void
    {
        /** @var \Throwable $request */
        $throwable = $data;
        if ($throwable instanceof \Throwable) {
            $this->throwable = $throwable;
        }
    }
}
