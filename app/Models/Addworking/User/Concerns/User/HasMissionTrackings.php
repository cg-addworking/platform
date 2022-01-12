<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\Mission\MissionTracking;

trait HasMissionTrackings
{
    public function missionTrackings()
    {
        return $this->hasMany(MissionTracking::class);
    }
}
