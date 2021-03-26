<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoverCheckTest extends TestCase
{
    public function testCanReturnTrue()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCanReturnFalse(){
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
