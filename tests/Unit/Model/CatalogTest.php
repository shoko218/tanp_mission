<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Model\Catalog;
use App\Model\CatalogProduct;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Catalog::class);
        $this->assertEmpty($eloquent->get());
        factory(Catalog::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testCatalogBelongsToManyProducts()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $catalog = factory(Catalog::class)->create();
        factory(CatalogProduct::class,$count)->create([
            'catalog_id' => $catalog->id,
        ]);
        $this->assertEquals($count,count($catalog->refresh()->products));
    }

    public function testCatalogBelongsToUser()
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($catalog->user);
    }

}
