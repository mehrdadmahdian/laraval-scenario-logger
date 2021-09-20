<?php


namespace Tests\Unit\Drivers;


use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageService;

class LaravelLogDriverTest extends \Tests\BaseTestCase
{
    protected $logFileAddress = 'vendor/orchestra/testbench-core/laravel/storage/logs/laravel.log';
    

    /**
     * @test
     */
    public function it_stores_generic_data()
    {
        if (file_exists($this->logFileAddress)) {
            unlink($this->logFileAddress);
        }
        $this->app['config']->set('laravel-scenario-logger.default_storage_driver', 'laravel_log');

        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        app()->make(StorageService::class)->store($data);

        $logContent = file_get_contents($this->logFileAddress);
        $this->assertStringContainsString(json_encode($data), $logContent);
    }

    /**
     * @test
     */
    public function it_stores_modules_data()
    {
        unlink($this->logFileAddress);
        $this->app['config']->set('laravel-scenario-logger.default_storage_driver', 'laravel_log');

        $data = [
            'services' => [
                'log_model_changes'=> ['a' => 'b'],
                'log_request' => ['a' => 'b'],
                'log_response' => ['a' => 'b'],
                'log_exception' => ['a' => 'b'],
                'log_manual_trace' => ['a' => 'b'],
            ]
            ];
        app()->make(StorageService::class)->store($data);

        $logContent = file_get_contents($this->logFileAddress);
        $this->assertStringContainsString(json_encode($data), $logContent);
    }
}