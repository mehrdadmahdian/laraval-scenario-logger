<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

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
        return [
            'message' => $this->throwable->getMessage(),
            'trace' => $this->throwable->getTraceAsString()
        ];
    }

    public function log($data): void
    {
        /** @var \Throwable $request */
        $throwable = $data;
        if ($throwable instanceof \Throwable) {
            $this->throwable = $throwable;
        }
    }
}
