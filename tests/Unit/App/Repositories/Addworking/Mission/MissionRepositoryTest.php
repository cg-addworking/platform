<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Mission\MissionRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MissionRepositoryTest extends TestCase
{
    use  RefreshDatabase;

    public function testClose()
    {
        Carbon::setTestNow(
            Carbon::create('2020-01-02 03:04:05')
        );

        $user    = factory(User::class)->create();
        $mission = factory(Mission::class)->create([
            'starts_at'      => "2020-01-01 00:00:00",
            'ends_at'        => null,
            'milestone_type' => null,
        ]);

        $repository = $this->app->make(MissionRepository::class);

        $this->assertTrue(
            $repository->close($mission, $user),
            "Closing mission should be successful"
        );

        $this->assertTrue(
            $mission->fresh()->closedBy->is($user),
            "Mission should be closed by user"
        );

        $this->assertCount(
            1,
            $mission->fresh()->milestones,
            "Closed mission should have an assigned milestone"
        );

        $this->assertTrue(
            Carbon::now()->equalTo($mission->fresh()->ends_at),
            "Closed mission should have its ends_at set"
        );

        $this->assertTrue(
            Carbon::now()->equalTo($mission->fresh()->closed_at),
            "Closed mission should have its ends_at set"
        );

        $this->assertEquals(
            Mission::STATUS_CLOSED,
            $mission->status,
            "Closed mission status should be 'closed'"
        );
    }
}
