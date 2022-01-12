<?php

namespace Components\Enterprise\ActivityReport\Domain\Interfaces;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Mission\MissionCollection;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReportMission;

interface ActivityReportMissionRepositoryInterface extends RepositoryInterface
{
    public function save(ActivityReportMission $activityReportMission): bool;
    public function associateMissions(ActivityReport $activityReport, MissionCollection $missions): void;
}
