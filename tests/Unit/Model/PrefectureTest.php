<?php

namespace Tests\Unit\Model;

use App\Model\Prefecture;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrefectureTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Prefecture::query()->delete();
        $eloquent = app(Prefecture::class);
        $this->assertEmpty($eloquent->get());
        factory(Prefecture::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testPrefectureHasManyUsers()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $prefecture = factory(Prefecture::class)->create();
        factory(User::class,$count)->create([
            'prefecture_id' => $prefecture->id,
        ]);
        $this->assertEquals($count,count($prefecture->refresh()->users));
    }
}
