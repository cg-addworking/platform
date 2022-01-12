<?php

namespace App\Providers\Support\Enterprise;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class EnterpriseAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('omnisearch', function ($user) {
            return $user->isSupport();
        });
    }
}
