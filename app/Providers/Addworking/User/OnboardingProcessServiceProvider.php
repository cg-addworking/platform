<?php

namespace App\Providers\Addworking\User;

use App\Models\Addworking\User\OnboardingProcess;
use App\Policies\Addworking\User\OnboardingProcessPolicy;
use App\Observers\Addworking\User\OnboardingProcessObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class OnboardingProcessServiceProvider
 * @package App\Providers\Addworking\User
 */
class OnboardingProcessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::policy(
            OnboardingProcess::class,
            OnboardingProcessPolicy::class
        );

        OnboardingProcess::observe(
            OnboardingProcessObserver::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
