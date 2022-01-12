<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Repositories\Addworking\Mission\MilestoneRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilestoneRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider getDateRangesDataProvider
     */
    public function testCreateFromMission($count, $from, $to, $granularity)
    {
        $repository = $this->app->make(MilestoneRepository::class);

        $mission = factory(Mission::class)->create([
            'starts_at'      => $from,
            'ends_at'        => $to,
            'milestone_type' => $granularity,
        ]);

        $milestones = $repository->createFromMission($mission);

        $this->assertCount($count, $milestones);

        foreach ($milestones as $milestone) {
            $this->assertTrue($milestone->exists);
        }
    }

    public function getDateRangesDataProvider()
    {
        return [
            "4 weeks starting 2020-01-01" => [
                'count'       => 4,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-01-22 00:00:00",
                'granularity' => Milestone::MILESTONE_WEEKLY,
            ],
            "1 week starting 2020-01-01" => [
                'count'       => 1,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-01-02 00:00:00",
                'granularity' => Milestone::MILESTONE_WEEKLY,
            ],
            "4 months starting 2020-01-01" => [
                'count'       => 4,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-04-01 00:00:00",
                'granularity' => Milestone::MILESTONE_MONTHLY,
            ],
            "1 month starting 2020-01-01" => [
                'count'       => 1,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-01-02 00:00:00",
                'granularity' => Milestone::MILESTONE_MONTHLY,
            ],
            "5 quarters starting 2020-01-01" => [
                'count'       => 5,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2021-01-01 00:00:00",
                'granularity' => Milestone::MILESTONE_QUARTERLY,
            ],
            "1 quarter starting 2020-01-01" => [
                'count'       => 1,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-01-02 00:00:00",
                'granularity' => Milestone::MILESTONE_QUARTERLY,
            ],
            "6 years starting 2020-01-01" => [
                'count'       => 6,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2025-01-01 00:00:00",
                'granularity' => Milestone::MILESTONE_ANNUAL,
            ],
            "1 year starting 2020-01-01" => [
                'count'       => 1,
                'from'        => "2020-01-01 00:00:00",
                'to'          => "2020-01-02 00:00:00",
                'granularity' => Milestone::MILESTONE_ANNUAL,
            ],
            "end of mission" => [
                'count'       => 1,
                'from'        => "2020-01-02 00:00:00",
                'to'          => "2020-03-04 00:00:00",
                'granularity' => Milestone::MILESTONE_END_OF_MISSION,
            ],
        ];
    }

    public function testCreateFromMissionWithoutEndsAt()
    {
        Carbon::setTestNow(
            Carbon::create('2020-01-22 00:00:00')
        );

        $repository = $this->app->make(MilestoneRepository::class);

        $mission = factory(Mission::class)->create([
            'starts_at'      => "2020-01-01",
            'ends_at'        => null,
            'milestone_type' => Milestone::MILESTONE_WEEKLY,
        ]);

        $milestones = $repository->createFromMission($mission);

        $this->assertCount(4, $milestones);

        Carbon::setTestNow(
            Carbon::create('2020-01-29 00:00:00')
        );

        $milestones = $repository->createFromMission($mission);

        $this->assertCount(5, $milestones);
    }
}
