<?php

namespace Escherchia\LaravelScenarioLogger\Logger;

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
     * @var
     */
    private $started_at;

    /**
     * @var LoggerServiceContainer
     */
    private $serviceContainer;

    /**
     * @var StorageService
     */
    private $storageService;

    protected function __construct()
    {
        $this->registerServices();
        $this->storageService = new StorageService();
    }

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

    public static function getInstance(): ScenarioLogger
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function start(): void
    {
        static::getInstance();
        self::$instance->started_at = now();
    }

    public static function report()
    {
        $serviceReports = [];
        /** @var LoggerServiceInterface $service */
        foreach (self::getInstance()->serviceContainer->all() as $key => $service) {
            $serviceReports[$key] = $service->report();
        }
        return [
            'started_at' => self::getInstance()->started_at,
            'services' => $serviceReports
        ];
    }

    public static function save()
    {
        self::getInstance()->storageService->store(static::report());
    }

}
