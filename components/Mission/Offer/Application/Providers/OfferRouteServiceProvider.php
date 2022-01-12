<?php

namespace Components\Mission\Offer\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class OfferRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Mission\Offer\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapOffer();
        $this->mapResponse();
        $this->mapAjaxOffer();
    }

    public function mapOffer()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('sector')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "offer";

                Route::get("{$base}", [
                    'uses' => 'OfferController@index',
                    'as' => 'sector.offer.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'OfferController@create',
                    'as' => 'sector.offer.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'OfferController@store',
                    'as' => 'sector.offer.store'
                ]);

                Route::get("{$base}/{offer}", [
                    'uses' => 'OfferController@show',
                    'as' => 'sector.offer.show'
                ]);

                Route::get("{$base}/{offer}/edit", [
                    'uses' => 'OfferController@edit',
                    'as' => 'sector.offer.edit'
                ]);

                Route::put("{$base}/{offer}/update", [
                    'uses' => 'OfferController@update',
                    'as' => 'sector.offer.update'
                ]);

                Route::get("{$base}/{offer}/send-to-enterprise", [
                    'uses' => 'OfferController@sendToEnterprise',
                    'as' => 'sector.offer.send_to_enterprise'
                ]);

                Route::post("{$base}/{offer}/send-to-enterprise/store", [
                    'uses' => 'OfferController@sendToEnterpriseStore',
                    'as' => 'sector.offer.send_to_enterprise.store'
                ]);

                Route::post("{$base}/set-response-deadline", [
                    'uses' => 'OfferController@setResponseDeadline',
                    'as' => 'sector.offer.set_response_deadline'
                ]);

                Route::get("{$base}/{offer}/close", [
                    'uses' => 'OfferController@close',
                    'as' => 'sector.offer.close'
                ]);

                Route::delete("{$base}/{offer}/delete", [
                    'uses' => 'OfferController@delete',
                    'as' => 'sector.offer.delete'
                ]);

                Route::delete("{$base}/{offer}/files/{file}/deleteFile", [
                    'uses' => 'OfferController@deleteFile',
                    'as' => 'sector.offer.delete_file'
                ]);
            });
    }

    public function mapAjaxOffer()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('sector')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "offer";

                Route::post("{$base}/get-referent", [
                    'uses' => 'OfferController@getReferentsOf',
                    'as' => 'sector.offer.get_referent'
                ]);

                Route::post("{$base}/get-workfield", [
                    'uses' => 'OfferController@getWorkfieldsOf',
                    'as' => 'sector.offer.get_workfield'
                ]);

                Route::post("{$base}/get-skills", [
                    'uses' => 'OfferController@getSkillsOf',
                    'as' => 'sector.offer.get_skill'
                ]);
            });
    }

    public function mapResponse()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('sector')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "offer/{offer}/response";

                Route::get("{$base}/", [
                    'uses' => 'ResponseController@index',
                    'as' => 'sector.response.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'ResponseController@create',
                    'as' => 'sector.response.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ResponseController@store',
                    'as' => 'sector.response.store'
                ]);

                Route::get("{$base}/{response}", [
                    'uses' => 'ResponseController@show',
                    'as' => 'sector.response.show'
                ]);

                Route::post("{$base}/{response}/accept", [
                    'uses' => 'ResponseController@accept',
                    'as' => 'sector.response.accept'
                ]);

                Route::post("{$base}/{response}/reject", [
                    'uses' => 'ResponseController@reject',
                    'as' => 'sector.response.reject'
                ]);
            });
    }
}
