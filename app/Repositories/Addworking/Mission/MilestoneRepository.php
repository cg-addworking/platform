<?php

namespace App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MilestoneRepository extends BaseRepository
{
    protected $model = Milestone::class;

    public function createFromMission(Mission $mission): Collection
    {
        $milestones = new Collection;

        $ranges = Milestone::getDateRanges(
            $mission->starts_at,
            $mission->ends_at ?? Carbon::now(),
            $mission->milestone_type
        );

        foreach ($ranges as list($starts_at, $ends_at)) {
            $milestones->push(
                $mission->milestones()->between($starts_at, $ends_at)->firstOrCreate(
                    compact('starts_at', 'ends_at')
                )
            );
        }

        return $milestones;
    }
}
