<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Scene;
use App\Model\Event;

class SceneTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Scene::query()->delete();
        $eloquent = app(Scene::class);
        $this->assertEmpty($eloquent->get());
        factory(Scene::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testSceneHasManyEvents()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $scene = factory(Scene::class)->create();
        factory(Event::class,$count)->create([
            'scene_id' => $scene->id,
        ]);
        $this->assertEquals($count,count($scene->refresh()->events));
    }
}
