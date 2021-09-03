<?php


namespace Tests\Unit;


use Escherchia\LaravelScenarioLogger\Exceptions\BadConfigException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelperTest extends \Tests\BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_returns_is_active_config_when_false()
    {
        $this->app['config']->set('laravel-scenario-logger.is_active', false);

        $this->assertFalse(lsl_is_active());
    }

    /**
     * @test
     */
    public function it_returns_is_active_config_when_true()
    {
        $this->app['config']->set('laravel-scenario-logger.is_active', true);

        $this->assertTrue(lsl_is_active());
    }

    /**
     * @test
     */
    public function it_get_exception_when_seted_wrong()
    {
        $this->expectException(BadConfigException::class);
        $this->app['config']->set('laravel-scenario-logger.is_active', 'aWrongText');

        lsl_is_active();
    }

    /**
     * @test
     */
    public function it_returns_true_when_service_active()
    {
        $this->app['config']->set('laravel-scenario-logger.active-services', [
            'a',
            'b',
        ]);

        $this->assertTrue(lsl_service_is_active('a'));
    }

    /**
     * @test
     */
    public function it_returns_true_when_service_is_not_active()
    {
        $this->app['config']->set('laravel-scenario-logger.active-services', [
            'a',
            'b',
        ]);

        $this->assertFalse(lsl_service_is_active('c'));
    }
}