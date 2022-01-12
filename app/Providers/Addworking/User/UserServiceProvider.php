<?php

namespace App\Providers\Addworking\User;

use App\Models\Addworking\User\NotificationPreferences;
use App\Models\Addworking\User\User;
use App\Models\Addworking\User\UserLog;
use App\Observers\Addworking\User\UserObserver;
use App\Policies\Addworking\User\MailablePolicy;
use App\Policies\Addworking\User\NotificationPreferencesPolicy;
use App\Policies\Addworking\User\UserPolicy;
use App\Policies\Addworking\User\UserLogPolicy;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(
            UserObserver::class
        );

        Gate::policy(
            User::class,
            UserPolicy::class
        );

        Gate::policy(
            UserLog::class,
            UserLogPolicy::class
        );

        Gate::policy(
            Mailable::class,
            MailablePolicy::class
        );

        Gate::policy(
            NotificationPreferences::class,
            NotificationPreferencesPolicy::class
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
