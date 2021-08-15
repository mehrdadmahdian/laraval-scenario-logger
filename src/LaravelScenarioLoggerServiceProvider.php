<?php

namespace Escherchia\LaravelScenarioLogger;

use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
use Escherchia\LaravelScenarioLogger\Middleware\LaravelScenarioLoggerMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class LaravelScenarioLoggerServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {

        $this->publishes([ __DIR__ . '/config/config.php' => config_path('laravel-scenario-logger.php')]);
        $this->mergeConfigFrom(__DIR__.'/config/config.php','laravel-scenario-logger');
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        if (lsl_is_active()) {
            $this->app->make(Kernel::class)->pushMiddleware(LaravelScenarioLoggerMiddleware::class);
            ScenarioLogger::start();
        }
    }
}
