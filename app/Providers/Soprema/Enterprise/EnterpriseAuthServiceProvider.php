<?php

namespace App\Providers\Soprema\Enterprise;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class EnterpriseAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Soprema\Enterprise\Covid19FormAnswer' => "App\Policies\Soprema\Enterprise\Covid19FormAnswerPolicy",
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
