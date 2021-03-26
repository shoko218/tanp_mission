<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\CatalogProduct;

class CatalogProductTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(CatalogProduct::class);
        $this->assertEmpty($eloquent->get());
        factory(CatalogProduct::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
}
