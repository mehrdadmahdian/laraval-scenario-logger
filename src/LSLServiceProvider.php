<?php

namespace Escherchia\LaravelScenarioLogger;

use Escherchia\LaravelScenarioLogger\Middleware\LSLMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LSLServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([ __DIR__.'/config.php' => config_path('laravel-scenario-logger.php')]);
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    public function boot()
    {
        $this->app->make(Kernel::class)->pushMiddleware(LSLMiddleware::class);

        Event::listen(['eloquent.saved: *', 'eloquent.created: *'], function() {
            dd('here');
        });
    }
}

