<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Addworking';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapEnterpriseRoutes();

        $this->mapSogetrelRoutes();

        $this->mapTseExpressMedicalRoutes();

        $this->mapCommonRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapCommonRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace('App\\Http\\Controllers\\Addworking\\Common')
            ->group(base_path('routes/addworking/common/comment.php'));
    }

    protected function mapEnterpriseRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace('App\\Http\\Controllers\\Addworking\\Enterprise')
            ->group(base_path('routes/enterprise/activity.php'));

        Route::middleware(['web', 'auth'])
            ->namespace('App\\Http\\Controllers\\Addworking\\Enterprise')
            ->group(base_path('routes/enterprise/enterprise.php'));
    }

    protected function mapSogetrelRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace('App\\Http\\Controllers\\Sogetrel')
            ->prefix('sogetrel')
            ->name('sogetrel.')
            ->group(base_path('routes/sogetrel.php'));
    }

    protected function mapTseExpressMedicalRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace('App\\Http\\Controllers\\TseExpressMedical\\Mission')
            ->prefix('tse_express_medical')
            ->name('tse_express_medical.')
            ->group(base_path('routes/tse_express_medical/mission.php'));
    }
}
