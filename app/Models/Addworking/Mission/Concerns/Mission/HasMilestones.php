<?php

namespace App\Models\Addworking\Mission\Concerns\Mission;

use App\Models\Addworking\Mission\Milestone;
use DateTime;

trait HasMilestones
{
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
