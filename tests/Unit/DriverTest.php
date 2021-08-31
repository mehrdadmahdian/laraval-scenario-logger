<?php


namespace Tests\Unit;


use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverTest extends \Tests\BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_data_with_default_driver()
    {
        $this->app['config']->set('laravel-scenario-logger.default-storage-driver', 'database');

        app()->make(StorageService::class)->store([]);

        $this->assertEquals(1, ScenarioLog::count());
    }
}