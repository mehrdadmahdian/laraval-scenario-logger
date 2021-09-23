<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

use Carbon\Carbon;
use Escherchia\LaravelScenarioLogger\Logger\Services\LoggerServiceInterface;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class ScenarioLogger
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @var string
     */
    private $started_at;

    /**
     * @var string
     */
    private $finished_at;

    /**
     * @var LoggerServiceContainer
     */
    private $serviceContainer;

    /**
     * @var StorageService
     */
    private $storageService;

    /**
     * @var string
     */
    private $name;

    /**
     * ScenarioLogger constructor.
     */
    protected function __construct()
    {
        $this->registerServices();
        $this->storageService = new StorageService();
    }

    /**
     * @throws \Exception
     */
    private function registerServices()
    {
        $this->serviceContainer = new LoggerServiceContainer();

        foreach (lsl_active_services() as $serviceName => $service) {
            $activeServiceClass = Arr::get($service, 'class');
            if (
                class_exists($activeServiceClass) and
                class_implements($activeServiceClass, LoggerServiceInterface::class)
            ) {
                $this->serviceContainer->add($serviceName, new $activeServiceClass);
            } else {
                throw new Exception($activeServiceClass .' class is not valid');
            }
        }

        /** @var LoggerServiceInterface $service */
        foreach ($this->serviceContainer->all() as $service) {
            $service->boot();
        }
    }

    /**
     * @return ScenarioLogger
     */
    public static function getInstance(): ScenarioLogger
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public static function isStarted(): bool
    {
        return isset(self::$instance);
    }

    /**
     *
     */
    public static function start(): void
    {
        if (static::couldBeStarted()) {
            static::getInstance();
            self::$instance->started_at = Carbon::now()->format('Y-m-d H:i:s.u');
        }
    }

    private static function couldBeStarted(): bool
    {
        $excludedRoutes = array();

        if (Config::has('laravel-scenario-logger.excluded_routes')) {
            if (is_array(Config::get('laravel-scenario-logger.excluded_routes'))) {
                $excludedRoutes  = Config::get('laravel-scenario-logger.excluded_routes');
            }
        }
        if (!app()->runningInConsole() && request()) {
            if (
                in_array(
                    str_replace(request()->getSchemeAndHttpHost(), '', url()->current()),
                    $excludedRoutes,
                    true
                )
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public static function report(): array
    {
        $serviceReports = [];
        /** @var LoggerServiceInterface $service */
        foreach (self::getInstance()->serviceContainer->all() as $key => $service) {
            $report = $service->report() ;
            if (count($report)) {
                $serviceReports[$key] = $report;
            }
        }

        return [
            'scenario-name' => self::getInstance()->name,
            'started_at' => self::getInstance()->started_at,
            'finished_at' => self::getInstance()->finished_at,
            'services' => $serviceReports,
        ];
    }

    /**
     *
     */
    public static function finish(): void
    {
        if (self::isStarted()) {
            self::getInstance()->finished_at = Carbon::now()->format('Y-m-d H:i:s.u');
            self::getInstance()->storageService->store(static::report());
        }
    }

    /**
     * @param $serviceKey
     * @param null|mixed ...$data
     */
    public static function logForService($serviceKey, $data = null): void
    {
        if (self::isStarted()) {
            if (lsl_service_is_active($serviceKey)) {
                $service = self::getInstance()->serviceContainer->get($serviceKey);
                if ($service and $service instanceof LoggerServiceInterface) {
                    $service->log($data);
                }
            }
        }

    }

    /**
     * @param string $name
     */
    public static function setScenarioName(string $name): void
    {
        if (self::isStarted()) {
            self::getInstance()->name = $name;
        }
    }

    /**
     * @param string $message
     * @param array $data
     */
    public static function trace(string $message, array $data = array()): void
    {
        if (self::isStarted()) {
            $logManualTrace = self::getInstance()->serviceContainer->get('log_manual_trace');
            if ($logManualTrace) {
                $backtrace = debug_backtrace();
                $bt = $backtrace[1];
                $logManualTrace->manualLog(
                    $message,
                    $data,
                    isset($bt['class']) ? $bt['class'] : null,
                    isset($bt['function']) ? $bt['function'] : null,
                    isset($bt['line']) ? $bt['line'] : null
                );
            }
        }
    }
}
