<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Mission\Milestone;
use Carbon\Carbon;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MilestoneRepositoryInterface;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Support\Collection;

class MilestoneRepository implements MilestoneRepositoryInterface
{
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
