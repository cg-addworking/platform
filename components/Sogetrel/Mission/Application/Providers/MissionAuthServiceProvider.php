<?php

namespace Components\Sogetrel\Mission\Application\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MissionAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment' =>
        "Components\Sogetrel\Mission\Application\Policies\MissionTrackingLineAttachmentPolicy",
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
