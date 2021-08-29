<?php


namespace Tests\Unit;


use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;

class ActivationTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_does_not_logs_request_if_active_is_false() {
        $this->app['config']->set('laravel-scenario-logger.is_active', false);
        $this->app['config']->set('laravel-scenario-logger.default-storage-driver', 'database');

        $this->get('/a-simple-get-request');
        $this->assertEquals(0, ScenarioLog::count());
    }

    /**
     * @test
     */
    public function it_does_not_logs_request_if_active_is_true() {
        $this->app['config']->set('laravel-scenario-logger.is_active', true);
        $this->app['config']->set('laravel-scenario-logger.default-storage-driver', 'database');

        $this->get('/a-simple-get-request');
        $this->assertEquals(1, ScenarioLog::count());
    }
}