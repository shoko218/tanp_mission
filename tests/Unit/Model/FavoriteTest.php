<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Favorite;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Favorite::class);
        $this->assertEmpty($eloquent->get());
        factory(Favorite::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
}
