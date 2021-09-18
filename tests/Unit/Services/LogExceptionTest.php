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
        $this->app['config']->set('laravel-scenario-logger.default-driver', 'database');

        $this->get('/a-route-with-exception');
        $scenarioLog = ScenarioLog::first();

        $this->assertArrayHasKey('log-exception', (array) $scenarioLog->raw_log['services']);
        $this->assertStringContainsString('Undefined variable $undefined_variable', $scenarioLog->raw_log['services']['log-exception']['message']);
    }
}