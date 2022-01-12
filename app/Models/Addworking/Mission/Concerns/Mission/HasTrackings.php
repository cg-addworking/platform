<?php

namespace App\Models\Addworking\Mission\Concerns\Mission;

use App\Models\Addworking\Mission\MissionTracking;

trait HasTrackings
{
    public function trackings()
    {
        return $this->hasMany(MissionTracking::class);
    }
}
