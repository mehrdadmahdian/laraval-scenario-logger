<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class LogResponse implements LoggerServiceInterface
{
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
        return [];
    }

    public function log($data): void
    {
        dd($data);
        // TODO: Implement log() method.
    }
}
