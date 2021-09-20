<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;

class MainTest extends BaseTestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_just_tests_making_request()
    {
        $this->get('/test');
        static::assertTrue(true);
    }
}
