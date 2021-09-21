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
        $this->artisan('migrate:refresh', ['--database' => 'normal'])->run();
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
        $app['config']->set('database.default', 'normal');

        $app['config']->set('database.connections.normal', [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT',3307),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
            'prefix' => '',
        ]);

        $app['config']->set('database.connections.alternate', [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT',3307),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
            'prefix' => '',
        ]);
    }

    public function defineRoutes($router)
    {
        $router->get('/test', function(){
            return 'here';
        });
        $router->get('/a-route-with-exception', function(){
            throw new \Exception(
                'this is an example exception message'
            );
        });
    }
}
