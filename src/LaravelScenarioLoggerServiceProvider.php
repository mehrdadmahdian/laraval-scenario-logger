<?php

namespace Escherchia\LaravelScenarioLogger;

use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
use Escherchia\LaravelScenarioLogger\Middleware\LaravelScenarioLoggerMiddleware;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LaravelScenarioLoggerServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->publishes([ __DIR__ . '/config/config.php' => config_path('laravel-scenario-logger.php')]);
        $this->loadViewsFrom(__DIR__.'/resources/view', 'lsl');
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'laravel-scenario-logger');
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');

        $this->subscribeToEvents();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->app->make(Kernel::class)->pushMiddleware(LaravelScenarioLoggerMiddleware::class);
    }

    private function subscribeToEvents(): void
    {
        Event::listen('*CommandStarting', function ($event, $data) {
            ScenarioLogger::start();
            ScenarioLogger::logForService('log_console', $data[0]);
        });
        Event::listen('*CommandFinished', function ($event, $data) {
            ScenarioLogger::logForService('log_console', $data[0]);
            ScenarioLogger::finish();
        });
}
}
