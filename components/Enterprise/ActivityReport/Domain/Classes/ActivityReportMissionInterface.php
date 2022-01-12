<?php

namespace Components\Enterprise\ActivityReport\Domain\Classes;

use App\Models\Addworking\Mission\Mission;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;

interface ActivityReportMissionInterface
{
    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getMission(): Mission;

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------
    public function setMission(Mission $mission): void;
    public function setActivityReport(ActivityReport $activityReport): void;
}
