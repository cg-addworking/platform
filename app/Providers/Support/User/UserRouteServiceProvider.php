<?php

namespace App\Providers\Support\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class UserRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Support\User';

    public function map()
    {
        // @todo put this in a trait!
        foreach (get_class_methods(self::class) as $method) {
            if (preg_match('/^map/', $method) && $method != 'map') {
                $this->$method();
            }
        }
    }

    public function mapOnboardingProcess()
    {
        Route::middleware('support')
            ->prefix('support/user')
            ->name('support.user.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/onboarding_process/export', [
                    'uses' => "OnboardingProcessController@export",
                    'as'   => "onboarding_process.export"
                ]);

                Route::resource('onboarding_process', 'OnboardingProcessController');
            });
    }
}
