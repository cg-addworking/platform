<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\User\OnboardingProcess;

trait HasOnboardingProcesses
{
    public function onboardingProcesses()
    {
        return $this->hasMany(OnboardingProcess::class);
    }

    public function getCurrentOnboardingProcessAttribute(): OnboardingProcess
    {
        return $this->onboardingProcesses()->incomplete()->first() ?? new OnboardingProcess;
    }
}
