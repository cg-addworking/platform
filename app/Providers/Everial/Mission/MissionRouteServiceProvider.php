<?php

namespace App\Providers\Everial\Mission;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MissionRouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Everial\Mission';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('everial')
            ->name('everial.mission.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::resource('referential', 'ReferentialController');
                Route::resource('referential.price', 'PriceController')->only('index');
            });

        Route::middleware(['web', 'auth'])
            ->prefix('everial')
            ->name('everial.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::resource('mission-offer', 'OfferController')->parameters(['mission-offer' => 'offer']);
                Route::resource('enterprise.offer.profile', 'ProfileController')->only(['create', 'store']);
                Route::resource('mission-proposal', 'ProposalController')->only(['store']);

                Route::get(
                    'enterprise/{enterprise}/offer/{offer}/assign',
                    'OfferController@assignIndex'
                )->name('enterprise.offer.assign.index');

                Route::post(
                    'enterprise/{enterprise}/offer/{offer}/assign/vendor/{vendor}/store',
                    'OfferController@assignStore'
                )->name('enterprise.offer.assign.store');
            });
    }
}
