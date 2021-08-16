<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

use Carbon\Carbon;
use Escherchia\LaravelScenarioLogger\Contracts\ScenarioLoggerUserProviderInterface;
use Escherchia\LaravelScenarioLogger\Logger\Services\LoggerServiceFactory;
use Escherchia\LaravelScenarioLogger\Logger\Services\LoggerServiceInterface;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Illuminate\Support\Facades\Config;
use phpDocumentor\Reflection\Types\True_;

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
     * @var ScenarioLoggerUserProviderInterface
     */
    private $user;

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

        foreach (Config::get('laravel-scenario-logger.active-services') as $activeService) {
            if (class_exists($activeService) and class_implements($activeService, LoggerServiceInterface::class)) {
                $this->serviceContainer->add($activeService, new $activeService());
            } else {
                $activeServiceObject = LoggerServiceFactory::factory($activeService);
                if ($activeServiceObject instanceof LoggerServiceInterface) {
                    $this->serviceContainer->add($activeService, $activeServiceObject);
                }
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

        if (Config::has('laravel-scenario-logger.excluded-routes')) {
            if (is_array(Config::get('laravel-scenario-logger.excluded-routes'))) {
                $excludedRoutes  = Config::get('laravel-scenario-logger.excluded-routes');
            }
        }
        if (!app()->runningInConsole() && request()) {
            if (in_array(request()->getRequestUri(), $excludedRoutes, true)) {
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
                $serviceReports[$key] = $service->report();
            }
        }

        return [
            'user_id' => self::getInstance()->user ? self::getInstance()->user->getId() : null,
            'user_name' => self::getInstance()->user ? self::getInstance()->user->getId(): null,
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
        self::getInstance()->finished_at = Carbon::now()->format('Y-m-d H:i:s.u');
        self::getInstance()->storageService->store(static::report());
    }

    /**
     * @param $serviceKey
     * @param mixed ...$data
     */
    public static function logForService($serviceKey, $data): void
    {
        $service = self::getInstance()->serviceContainer->get($serviceKey);
        if ($service and $service instanceof LoggerServiceInterface) {
            $service->log($data);
        }
    }

    /**
     * @param ScenarioLoggerUserProviderInterface $user
     */
    public static function setUser(ScenarioLoggerUserProviderInterface $user)
    {
        self::getInstance()->user = $user;
    }

    /**
     * @param string $message
     * @param array $data
     */
    public static function pushToTrace(string $message, array $data = array()): void
    {
        $logManualTrace = self::getInstance()->serviceContainer->get('log-manual-trace');
        if ($logManualTrace) {
            $backtrace  = debug_backtrace();
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
