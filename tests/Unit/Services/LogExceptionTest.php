<?php


namespace Tests\Unit\Services;

use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;

class LogExceptionTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test 
     */
    public function it_works_when_an_exception_fires()
    {
        $this->app['config']->set('laravel-scenario-logger.default_storage_driver', 'database');

        $this->get('/a-route-with-exception');
        $scenarioLog = ScenarioLog::first();

        $this->assertArrayHasKey('log_exception', (array) $scenarioLog->raw_log['services']);
        $this->assertStringContainsString('this is an example exception message', $scenarioLog->raw_log['services']['log_exception']['message']);
    }
}