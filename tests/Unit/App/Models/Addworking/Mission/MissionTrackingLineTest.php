<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Mission\MissionTrackingLine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class MissionTrackingLineTest extends ModelTestCase
{
    use RefreshDatabase;

    protected $class = MissionTrackingLine::class;

    public function testScopeSearch()
    {
        $line = factory(MissionTrackingLine::class)->create();
        $line->missionTracking->mission->vendor->update(['name' => "VENDOR"]);
        $line->missionTracking->mission->customer->update(['name' => "CUSTOMER"]);
        $line->missionTracking->mission->update(['number' => 1234]);

        $this->assertEquals(
            1,
            MissionTrackingLine::search(23)->count(),
            'We should find the mission tracking line by number'
        );

        $this->assertEquals(
            0,
            MissionTrackingLine::search('foo')->count(),
            'We should find 0 mission tracking line by this search term'
        );

        $this->assertEquals(
            1,
            MissionTrackingLine::search('NDO')->count(),
            'We should find the mission tracking line by vendor name'
        );

        $this->assertEquals(
            1,
            MissionTrackingLine::search('UST')->count(),
            'We should find the mission tracking line by customer name'
        );
    }
}
