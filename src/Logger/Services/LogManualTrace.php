<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class LogManualTrace implements LoggerServiceInterface
{
    public function boot(): void
    {

    }

    public function report(): array
    {
    }
}
