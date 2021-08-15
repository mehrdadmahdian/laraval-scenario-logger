<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class LogRequest implements LoggerServiceInterface
{
    private $request;

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
        if ($this->request instanceof Request) {
            return [
                'params' => $this->request->all(),
                'is_json' => $this->request->isJson(),
                'url' => $this->request->url(),
                'uri' => $this->request->getRequestUri(),
                'method' => $this->request->method(),
                'port' => $this->request->getPort(),
                'ip' => $this->request->getClientIp(),
                'segments' => $this->request->segments()
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
        /** @var Request $request */
        $request = $data;
         if ($request instanceof Request) {
             $this->request = clone $request;
         }
    }
}
