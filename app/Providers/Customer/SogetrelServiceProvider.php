<?php

namespace App\Providers\Customer;

use Illuminate\Support\ServiceProvider;

class SogetrelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Http\Controllers\Addworking\User\PassworkController::class,
            \App\Http\Controllers\Sogetrel\User\PassworkController::class
        );

        $this->app->bind(
            \App\Http\Controllers\Addworking\Enterprise\EnterpriseController::class,
            \App\Http\Controllers\Sogetrel\Enterprise\EnterpriseController::class
        );

        $this->app->bind(
            \App\Models\Addworking\Common\Passwork::class,
            \App\Models\Sogetrel\User\Passwork::class
        );

        // clear current route's controller (if any)
        if ($route = $this->app->request->route()) {
            $route->controller = false;
        }
    }
}
