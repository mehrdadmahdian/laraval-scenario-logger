<?php

namespace Tests;

use Escherchia\LaravelScenarioLogger\LaravelScenarioLoggerServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelScenarioLoggerServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();

        $this->artisan('migrate:refresh', ['--database' => 'testing'])->run();
    }

    /**
     * Resolve application HTTP exception handler.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton('Illuminate\Contracts\Debug\ExceptionHandler', LSLExceptionHandler::class);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');

        $app['config']->set('database.connections.testing', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => 'root',
            'password' => '',
            'database' => env('DB_DATABASE', 'laravel-scenario-logger-testing'),
            'prefix' => '',
        ]);
    }
}
