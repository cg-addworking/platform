<?php

namespace App\Providers\Addworking\Mission;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MissionRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Addworking\Mission';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapMissionOfferRoutes();

        $this->mapMissionTrackingRoutes();

        $this->mapMissionTrackingLineRoutes();

        $this->mapMissionProposalResponseRoutes();

        $this->mapMissionPurchaseOrderRoutes();

        $this->mapMissionRoutes();

        $this->mapMissionProposalRoutes();
    }

    public function mapMissionOfferRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/offer/{offer}/summary', 'OfferController@summary')
                    ->name('enterprise.offer.summary');

                Route::get('enterprise/{enterprise}/offer/{offer}/profile/create', 'ProfileController@create')
                    ->name('enterprise.offer.profile.create');

                Route::post('enterprise/{enterprise}/offer/{offer}/profile/store', 'ProfileController@store')
                    ->name('enterprise.offer.profile.store');

                Route::get(
                    'enterprise/{enterprise}/offer/{offer}/assign',
                    'OfferController@assignIndex'
                )->name('enterprise.offer.assign.index');

                Route::post(
                    'enterprise/{enterprise}/offer/{offer}/assign/vendor/{vendor}/store',
                    'OfferController@assignStore'
                )->name('enterprise.offer.assign.store');

                Route::post(
                    'enterprise/{enterprise}/offer/{offer}/send-request-close',
                    'OfferController@sendRequestClose'
                )->name('enterprise.offer.send-request-close');

                Route::get('enterprise/{enterprise}/offer/{offer}/request', 'OfferController@requestClose')
                    ->name('enterprise.offer.request');
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/mission-offers', 'OfferController@index')
                    ->name('mission.offer.index');

                Route::get('/mission-offer/create', 'OfferController@create')
                    ->name('mission.offer.create');

                Route::post('/mission-offer/store', 'OfferController@store')
                    ->name('mission.offer.store');

                Route::get('/mission-offer/{offer}', 'OfferController@show')
                    ->name('mission.offer.show');

                Route::get('/mission-offer/{offer}/edit', 'OfferController@edit')
                    ->name('mission.offer.edit');

                Route::post('/mission-offer/{offer}/update', 'OfferController@update')
                    ->name('mission.offer.update');

                Route::delete('/mission-offer/{offer}', 'OfferController@destroy')
                    ->name('mission.offer.destroy');

                Route::post('/mission-offer/{offer}/close', 'OfferController@close')
                    ->name('mission.offer.close');

                Route::get('/mission-offer/{offer}/resend-proposal', 'OfferController@resendProposal')
                    ->name('mission.offer.resend-proposal');
            });
    }

    public function mapMissionTrackingRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/mission/tracking', 'MissionTrackingController@index')->name('mission.tracking.index');

                Route::resource('mission.tracking', 'MissionTrackingController')->except(['index']);
            });
    }

    public function mapMissionTrackingLineRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "/mission/{mission}/tracking/{tracking}";

                Route::get("{$base}/line", [
                    'uses' => "MissionTrackingLineController@index",
                    'as'   => "mission.tracking.line.index",
                ]);

                Route::get("{$base}/line/create", [
                    'uses' => "MissionTrackingLineController@create",
                    'as'   => "mission.tracking.line.create",
                ]);

                Route::post("{$base}/line/store", [
                    'uses' => "MissionTrackingLineController@store",
                    'as'   => "mission.tracking.line.store",
                ]);

                Route::get("{$base}/line/{line}", [
                    'uses' => "MissionTrackingLineController@show",
                    'as'   => "mission.tracking.line.show",
                ]);

                Route::get("{$base}/line/{line}/edit", [
                    'uses' => "MissionTrackingLineController@edit",
                    'as'   => "mission.tracking.line.edit",
                ]);

                Route::post("{$base}/line/{line}/update", [
                    'uses' => "MissionTrackingLineController@update",
                    'as'   => "mission.tracking.line.update",
                ]);

                Route::delete("{$base}/line/{line}", [
                    'uses' => "MissionTrackingLineController@destroy",
                    'as'   => "mission.tracking.line.destroy",
                ]);

                Route::post("{$base}/line/{line}/validation", [
                    'uses' => "MissionTrackingLineController@validation",
                    'as'   => "mission.tracking.line.validation",
                ]);
            });
    }

    public function mapMissionProposalResponseRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::post(
                    'enterprise/{enterprise}/offer/{offer}/proposal/{proposal}/response/{response}/status',
                    'ProposalResponseController@updateResponseStatus'
                )->name('enterprise.offer.proposal.response.status');

                Route::get(
                    'enterprise/{enterprise}/offer/{offer}/responses',
                    'ProposalResponseController@indexOfferAnswers'
                )->name('enterprise.offer.response.index');

                Route::resource('enterprise.offer.proposal.response', 'ProposalResponseController');

                Route::post(
                    'enterprise/{enterprise}/offer/{offer}/proposal/{proposal}/response/{response}/mission',
                    'ProposalResponseController@mission'
                )->name('enterprise.offer.proposal.response.mission');
            });
    }

    public function mapMissionPurchaseOrderRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/purchase_order', 'PurchaseOrderController@index')
                    ->name('enterprise.purchase_order.index');

                Route::resource('enterprise.mission.purchase_order', 'PurchaseOrderController')
                    ->except(['create', 'edit']);

                Route::post(
                    '/enterprise/{enterprise}/mission/{mission}/purchase_order/{purchase_order}/send',
                    'PurchaseOrderController@send'
                )->name('enterprise.mission.purchase_order.send');
            });
    }

    public function mapMissionRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/mission/{mission}/close', 'MissionController@close')
                    ->name('mission.close');

                Route::post('/mission/{mission}/note', 'MissionController@note')
                    ->name('mission.note');

                Route::post('/mission/{mission}/status', 'MissionController@status')
                    ->name('mission.status');

                Route::get('/mission/{mission}/milestone-type/create', 'MissionController@createMilestoneType')
                    ->name('mission.create_milestone_type');

                Route::post('/mission/{mission}/milestone-type/store', 'MissionController@storeMilestoneType')
                    ->name('mission.store_milestone_type');

                Route::resource('mission', 'MissionController');
            });
    }

    public function mapMissionProposalRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/mission-proposal', 'ProposalController@index')
                    ->name('mission.proposal.index');

                Route::get('/mission-proposal/create/offer/{offer?}', 'ProposalController@create')
                    ->name('mission.proposal.create');

                Route::post('/mission-proposal/store', 'ProposalController@store')
                    ->name('mission.proposal.store');

                Route::get('/mission-proposal/{proposal}', 'ProposalController@show')
                    ->name('mission.proposal.show');

                Route::get('/mission-proposal/{proposal}/edit', 'ProposalController@edit')
                    ->name('mission.proposal.edit');

                Route::post('/mission-proposal/{proposal}/update', 'ProposalController@update')
                    ->name('mission.proposal.update');

                Route::post('/mission-proposal/{proposal}/destroy', 'ProposalController@destroy')
                    ->name('mission.proposal.destroy');

                Route::post('/mission-proposal/{proposal}/assign', 'ProposalController@assign')
                    ->name('mission.proposal.assign');

                Route::post('/mission-proposal/{proposal}/status', 'ProposalController@updateProposalStatus')
                    ->name('mission.proposal.status');
            });
    }
}
