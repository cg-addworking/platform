<?php

namespace Components\Enterprise\ActivityReport\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Mission\Mission;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportMissionInterface;
use Illuminate\Database\Eloquent\Model;

class ActivityReportMission extends Model implements ActivityReportMissionInterface
{
    use HasUuid;

    protected $table = "addworking_enterprise_activity_report_has_missions";

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function activityReport()
    {
        return $this->belongsTo(ActivityReport::class, 'activity_report_id')->withDefault();
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getMission(): Mission
    {
        return $this->customer;
    }


    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setMission(Mission $mission): void
    {
        $this->mission()->associate($mission);
    }

    public function setActivityReport(ActivityReport $activityReport): void
    {
        $this->activityReport()->associate($activityReport);
    }
}
