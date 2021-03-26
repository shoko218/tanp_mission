<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Generation;

class GenerationTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Generation::query()->delete();
        $eloquent = app(Generation::class);
        $this->assertEmpty($eloquent->get());
        factory(Generation::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
}
