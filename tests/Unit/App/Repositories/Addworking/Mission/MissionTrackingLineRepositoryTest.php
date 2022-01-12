<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class MissionTrackingLineRepositoryTest extends TestCase
{
    public function testList()
    {
        /** @var MissionTrackingLineRepository $repo */
        $repo = app(MissionTrackingLineRepository::class);

        $this->assertInstanceOf(Builder::class, $repo->list(null, [
            'quantity' => 4
        ]));
    }
}
