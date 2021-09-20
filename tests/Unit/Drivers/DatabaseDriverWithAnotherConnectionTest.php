<?php


namespace Tests\Unit\Drivers;


use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DatabaseDriverWithAnotherConnectionTest extends \Tests\BaseTestCase
{
    use RefreshDatabase;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default_storage_driver', 'normal');

        $app['config']->set('database.connections.normal', [
            'driver' => 'mysql',
            'host' => env('ALTERNATE_DB_HOST'),
            'port' => env('ALTERNATE_DB_PORT'),
            'username' => env('ALTERNATE_DB_USERNAME'),
            'password' => env('ALTERNATE_DB_PASSWORD'),
            'database' => env('ALTERNATE_DB_DATABASE'),
            'prefix' => '',
        ]);
    }

    /**
     * @test
     */
    public function it_uses_laravel_connection_configs()
    {

        $this->app['config']->set('laravel-scenario-logger.default_storage_driver', 'database');
        $this->app['config']->set('laravel-scenario-logger.drivers.database.connection', 'alternate');

        app()->make(StorageService::class)->store([
            'services' => [
            ]
        ]);

        $this->assertEquals(1, ScenarioLog::count());
    }
}