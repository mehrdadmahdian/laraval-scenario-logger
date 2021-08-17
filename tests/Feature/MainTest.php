<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;

class MainTest extends BaseTestCase
{
//    use RefreshDatabase;

    /** @test */
    public function basic_test()
    {
        $this->get('/');
        static::assertTrue(true);
    }
}
