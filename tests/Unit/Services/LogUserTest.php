<?php


namespace Tests\Unit\Services;

use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
use Tests\User;
use Tests\BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;

class LogUserTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * @test 
     */
    public function it_test_user_logging_feature()
    {

        $user = User::create(['name' => 'me', 'email' => 'me@me.com', 'password' => 'asdasd']);
        $this->actingAs($user); 
        $this->get('/test');
        $scenarioLog = ScenarioLog::first();
        $this->assertArrayHasKey('log_user', (array) $scenarioLog->raw_log['services']);
    }
}
