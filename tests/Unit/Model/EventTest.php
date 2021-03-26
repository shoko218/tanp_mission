<?php

namespace Tests\Unit\Model;

use App\Model\Lover;
use App\Model\Scene;
use Tests\TestCase;
use App\User;
use App\Model\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Event::class);
        $this->assertEmpty($eloquent->get());
        factory(Event::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testEventBelongsToLover()
    {
        $this->seed('BaseSeeder');
        $lover = factory(Lover::class)->create();
        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
        ]);
        $this->assertNotEmpty($event->lover);
    }

    public function testEventBelongsToScene()
    {
        $this->seed('BaseSeeder');
        $scene = factory(Scene::class)->create();
        $event = factory(Event::class)->create([
            'scene_id' => $scene->id,
        ]);
        $this->assertNotEmpty($event->scene);
    }
}
