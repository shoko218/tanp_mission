<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Model\Relationship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Lover;

class RelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Relationship::query()->delete();
        $eloquent = app(Relationship::class);
        $this->assertEmpty($eloquent->get());
        factory(Relationship::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testRelationshipHasManyLovers()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $relationship = factory(Relationship::class)->create();
        factory(Lover::class,$count)->create([
            'relationship_id' => $relationship->id,
        ]);
        $this->assertEquals($count,count($relationship->refresh()->lovers));
    }
}
