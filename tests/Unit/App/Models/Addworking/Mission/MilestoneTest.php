<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use Carbon\Carbon;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class MilestoneTest extends ModelTestCase
{
    protected $class = Milestone::class;

    /**
     * @dataProvider getDateRangesDataProvider
     */
    public function testGetDateRanges($count, $from, $to, $granularity)
    {
        $this->assertCount($count, Milestone::getDateRanges(new Carbon($from), new Carbon($to), $granularity));
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

    public function testScopeBetween()
    {
        factory(Milestone::class, 5)->make()->each(function ($milestone) {
            $milestone->fill([
                'starts_at' => "2020-01-01 00:00:00",
                'ends_at'   => "2020-02-01 00:00:00",
            ])->save();
        });

        factory(Milestone::class, 5)->make()->each(function ($milestone) {
            $milestone->fill([
                'starts_at' => "2020-02-01 00:00:00",
                'ends_at'   => "2020-03-01 00:00:00",
            ])->save();
        });

        $this->assertEquals(
            5,
            Milestone::between(new Carbon('2020-01-01 00:00:00'), new Carbon("2020-02-01 00:00:00"))->count(),
            "There should be 5 milestones between January and February"
        );

        $this->assertEquals(
            10,
            Milestone::between(new Carbon('2020-01-01 00:00:00'), new Carbon("2020-03-01 00:00:00"))->count(),
            "There should be 10 milestones between January and March"
        );

        $this->assertEquals(
            5,
            Milestone::between(new Carbon('2020-02-01 00:00:00'), new Carbon("2020-03-01 00:00:00"))->count(),
            "There should be 5 milestones between February and March"
        );
    }
}
