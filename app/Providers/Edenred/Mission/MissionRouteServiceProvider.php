<?php

namespace App\Providers\Edenred\Mission;

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
    protected $namespace = 'App\Http\Controllers\Edenred\Mission';

    /**
     * Define your route model bindings, pattern filters, etc.
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
            ->prefix('edenred')
            ->name('edenred.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/offer/{offer}/response', [
                    'uses' => "OfferController@response",
                    'as'   => "enterprise.offer.response.index",
                ]);

                Route::resource('mission-offer', 'OfferController')
                    ->parameters(['mission-offer' => 'offer']);

                Route::resource('enterprise.offer.profile', 'ProfileController')
                    ->only(['create', 'store']);

                Route::get(
                    'enterprise/{enterprise}/offer/{offer}/responses',
                    'ProposalResponseController@indexOfferAnswers'
                )->name('enterprise.offer.response.index');

                Route::resource('enterprise.offer.proposal.response', 'ProposalResponseController');
            });
    }
}
