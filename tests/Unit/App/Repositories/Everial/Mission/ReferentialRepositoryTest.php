<?php

namespace Tests\Unit\App\Repositories\Everial\Mission;

use App\Models\Everial\Mission\Referential;
use App\Repositories\Everial\Mission\ReferentialRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferentialRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testList()
    {
        $repository = $this->app->make(ReferentialRepository::class);

        $referentials = factory(Referential::class, 3)->create();

        $this->assertEquals(
            3,
            $repository->list()->count(),
            'We should list 3 referentials');
    }
}
