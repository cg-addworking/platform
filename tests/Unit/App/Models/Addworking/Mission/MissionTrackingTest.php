<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Mission\MissionTracking;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class MissionTrackingTest extends ModelTestCase
{
    protected $class = MissionTracking::class;

    public function testScopeMissionNumber()
    {
        $tracking = factory(MissionTracking::class)->create();

        $this->assertCount(1, MissionTracking::missionNumber($tracking->mission->number)->get());
    }
}
