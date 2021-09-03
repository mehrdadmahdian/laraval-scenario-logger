<?php


namespace Tests\Unit\Drivers;


use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DatabaseDriverTest extends \Tests\BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_generic_data()
    {
        $this->app['config']->set('laravel-scenario-logger.default-driver', 'database');

        app()->make(StorageService::class)->store(['a' => 1, 'b' => 2, 'c' => 3]);

        $scenarioLog = ScenarioLog::first();
        $this->assertArrayHasKey('a', (array) $scenarioLog->raw_log);
        $this->assertArrayHasKey('b', (array) $scenarioLog->raw_log);
        $this->assertArrayHasKey('c', (array) $scenarioLog->raw_log);
    }

    /**
     * @test
     */
    public function it_stores_modules_data()
    {
        $this->app['config']->set('laravel-scenario-logger.default-driver', 'database');

        app()->make(StorageService::class)->store([
            'services' => [
                'log_model_changes'=> ['a' => 'b'],
                'log_request' => ['a' => 'b'],
                'log_response' => ['a' => 'b'],
                'log_exception' => ['a' => 'b'],
                'log_manual_trace' => ['a' => 'b'],
            ]
        ]);

        $scenarioLog = ScenarioLog::first();
        $this->assertArrayHasKey('log_model_changes', (array) $scenarioLog->raw_log['services']);
        $this->assertArrayHasKey('log_request', $scenarioLog->raw_log['services']);
        $this->assertArrayHasKey('log_response', $scenarioLog->raw_log['services']);
        $this->assertArrayHasKey('log_exception', $scenarioLog->raw_log['services']);
        $this->assertArrayHasKey('log_manual_trace', $scenarioLog->raw_log['services']);
    }

    /**
     * @test
     */
    public function it_uses_laravel_connection_configs()
    {
        $this->app['config']->set('database.connections.new-connection', [
            'driver' => 'mysql',
            'host' => env('ALTERNATE_DB_HOST'),
            'username' => env('ALTERNATE_DB_USERNAME'),
            'password' => env('ALTERNATE_DB_PASSWORD'),
            'database' => env('ALTERNATE_DB_DATABASE'),
            'prefix' => '',
        ]);
        $this->app['config']->set('laravel-scenario-logger.default-driver', 'database');
        $this->app['config']->set('laravel-scenario-logger.drivers.database.connection', 'new-connection');

        app()->make(StorageService::class)->store([
            'services' => [
            ]
        ]);

        $this->assertEquals(1, ScenarioLog::count());
    }
}