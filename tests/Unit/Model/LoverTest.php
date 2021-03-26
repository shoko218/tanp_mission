<?php

namespace Tests\Unit\Model;

use App\Model\Lover;
use App\Model\Order;
use App\Model\Relationship;
use App\User;
use Tests\TestCase;
use App\Model\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoverTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Lover::class);
        $this->assertEmpty($eloquent->get());
        factory(Lover::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testLoverBelongsToUser()
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($lover->user);
    }

    public function testLoverBelongsToRelationship()
    {
        $this->seed('BaseSeeder');
        $relationship = factory(Relationship::class)->create();
        $lover = factory(Lover::class)->create([
            'relationship_id' => $relationship->id,
        ]);
        $this->assertNotEmpty($lover->relationship);
    }

    public function testLoverHasManyEvents()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $lover = factory(Lover::class)->create();
        factory(Event::class,$count)->create([
            'lover_id' => $lover->id,
        ]);
        $this->assertEquals($count,count($lover->refresh()->events));
    }
}
