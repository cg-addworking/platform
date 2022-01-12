<?php

namespace Components\Enterprise\ActivityReport\Application\Repositories;

use App\Models\Addworking\Mission\MissionCollection;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReportMission;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportMissionInterface;
use Components\Enterprise\ActivityReport\Domain\Exceptions\ActivityReportMissionCreationFailedException;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportMissionRepositoryInterface;

class ActivityReportMissionRepository implements ActivityReportMissionRepositoryInterface
{
    public function make($data = []): ActivityReportMission
    {
        return new ActivityReportMission($data);
    }

    public function save(ActivityReportMissionInterface $activityReportMission): bool
    {
        $saved = $activityReportMission->save();

        if (!$saved) {
            throw new ActivityReportMissionCreationFailedException($activityReportMission->getMission()->id);
        }

        return $saved;
    }

    public function associateMissions(ActivityReport $activityReport, MissionCollection $missions): void
    {
        foreach ($missions as $mission) {
            $activityReportMission = $this->make();
            $activityReportMission->setActivityReport($activityReport);
            $activityReportMission->setMission($mission);
            $this->save($activityReportMission);
        }
    }
}
