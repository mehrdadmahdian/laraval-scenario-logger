<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

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
        $data =  [
            'status_code' => $this->response->status(),
            'status_text' => $this->response->statusText(),
            'content' => $this->response->getContent(),
            'content_type' => get_class($this->response->getOriginalContent())
        ];

        if (
            Config::has('laravel-scenario-logger.service-configuration.log-response.disable-store-content') &&
            Config::get('laravel-scenario-logger.service-configuration.log-response.disable-store-content'))
        {
            unset($data['content']);
        }
        return $data;
    }

    public function log($data): void
    {
        /** @var Response $request */

        $response = $data;

        if ($response instanceof Response) {
            $this->response = clone $response;
        }
    }
}
