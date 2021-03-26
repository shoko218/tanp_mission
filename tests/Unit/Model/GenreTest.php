<?php

namespace Tests\Unit\Model;

use App\Model\Genre;
use App\Model\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Genre::query()->delete();
        $eloquent = app(Genre::class);
        $this->assertEmpty($eloquent->get());
        factory(Genre::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testGenreHasManyProducts()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $genre = factory(Genre::class)->create();
        factory(Product::class,$count)->create([
            'genre_id' => $genre->id,
        ]);
        $this->assertEquals($count,count($genre->refresh()->products));
    }
}
