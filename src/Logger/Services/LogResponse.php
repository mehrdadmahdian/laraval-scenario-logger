<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class LogResponse implements LoggerServiceInterface
{
    /**
     * @var array|Response
     */
    private $response;

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
        $data = [];
        if ($this->response) {
            $data =  [
                'status_code' => $this->response ? $this->response->status() : null,
                'status_text' => $this->response ? $this->response->statusText() : null,
                'content' => $this->response ? $this->response->getContent() : null,
//                'content_type' => $this->response ? get_class($this->response->getOriginalContent()) : null,
            ];
            if (
                Config::has('laravel-scenario-logger.service_configuration.log_response.disable-store-content') &&
                Config::get('laravel-scenario-logger.service_configuration.log_response.disable-store-content')) {
                unset($data['content']);
            }
        }

        return $data;
    }

    /**
     * @param mixed $data
     */
    public function log($data): void
    {
        /** @var Response $request */
        $response = $data;

        if ($response instanceof Response) {
            $this->response = clone $response;
        }
    }
}
