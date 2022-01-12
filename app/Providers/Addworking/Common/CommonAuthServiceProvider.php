<?php

namespace App\Providers\Addworking\Common;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CommonAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Addworking\Common\Job' => 'App\Policies\Addworking\Common\JobPolicy',
        'App\Models\Addworking\Common\Skill' => 'App\Policies\Addworking\Common\SkillPolicy',
        'App\Models\Addworking\Common\Passwork' => 'App\Policies\Addworking\Common\PassworkPolicy',
        'App\Models\Addworking\Common\CsvLoaderReport' => 'App\Policies\Addworking\Common\CsvLoaderReportPolicy',
        'App\Models\Addworking\Common\Folder' => 'App\Policies\Addworking\Common\FolderPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
