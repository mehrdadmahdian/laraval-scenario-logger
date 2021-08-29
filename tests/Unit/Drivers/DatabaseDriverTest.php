<?php


namespace Tests\Unit\Drivers;


use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseDriverTest extends \Tests\BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_generic_data()
    {
        $this->app['config']->set('laravel-scenario-logger.default-storage-driver', 'database');

        app()->make(StorageService::class)->store(['a' => 1, 'b' => 2, 'c' => 3]);

        $scenarioLog = ScenarioLog::first();
        $this->assertArrayHasKey('a', $scenarioLog->generic_info);
        $this->assertArrayHasKey('b', $scenarioLog->generic_info);
        $this->assertArrayHasKey('c', $scenarioLog->generic_info);
    }

    /**
     * @test
     */
    public function it_stores_modules_data()
    {
        $this->app['config']->set('laravel-scenario-logger.default-storage-driver', 'database');

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
        $this->assertArrayHasKey('log_model_changes', $scenarioLog->generic_info);
        $this->assertArrayHasKey('log_request', $scenarioLog->generic_info);
        $this->assertArrayHasKey('log_response', $scenarioLog->generic_info);
        $this->assertArrayHasKey('log_exception', $scenarioLog->generic_info);
        $this->assertArrayHasKey('log_manual_trace', $scenarioLog->generic_info);
    }
}