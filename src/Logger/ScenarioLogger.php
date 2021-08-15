<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

use Carbon\Carbon;
use Escherchia\LaravelScenarioLogger\Contracts\ScenarioLoggerUserProviderInterface;
use Escherchia\LaravelScenarioLogger\Logger\Services\LoggerServiceFactory;
use Escherchia\LaravelScenarioLogger\Logger\Services\LoggerServiceInterface;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
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

        foreach(Config::get('laravel-scenario-logger.active-services') as $activeService) {
            if (class_exists($activeService) and class_implements($activeService,LoggerServiceInterface::class)) {
                $this->serviceContainer->add($activeService, new $activeService());
            } else {
                $activeServiceObject = LoggerServiceFactory::factory($activeService);
                if ($activeServiceObject instanceof LoggerServiceInterface) {
                    $this->serviceContainer->add($activeService, $activeServiceObject);
                }
            }
        }

        /** @var LoggerServiceInterface $service */
        foreach($this->serviceContainer->all() as $service) {
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
     *
     */
    public static function start(): void
    {
        static::getInstance();
        self::$instance->started_at = now();
    }

    /**
     * @return array
     */
    public static function report(): array
    {
        $serviceReports = [];
        /** @var LoggerServiceInterface $service */
        foreach (self::getInstance()->serviceContainer->all() as $key => $service) {
            $serviceReports[$key] = $service->report();
        }
        return [
            'user_id' => self::getInstance()->user ? self::getInstance()->user->getId() : null,
            'user_name' => self::getInstance()->user ? self::getInstance()->user->getId(): null,
            'started_at' => self::getInstance()->started_at,
            'finished_at' => self::getInstance()->finished_at,
            'services' => $serviceReports
        ];
    }

    /**
     *
     */
    public static function finish(): void
    {
        self::getInstance()->finished_at = Carbon::now()->format('Y-m-d H:i:s');
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

}
