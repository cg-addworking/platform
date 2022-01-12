<?php

namespace Components\Sogetrel\Mission\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MissionRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Sogetrel\Mission\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapProfile();
        $this->mapProposal();
        $this->mapMissionTrackingLineAttachment();
    }

    protected function mapProfile()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('sogetrel/mission-offer/{offer}/profile/create', [
                    'uses' => "ProfileController@create",
                    'as'   => "sogetrel.mission.offer.profile.create",
                ]);
            });
    }

    public function mapProposal()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('sogetrel/mission-proposal/create/offer/{offer?}', [
                    'uses' => "ProposalController@create",
                    'as'   => "sogetrel.mission.proposal.create",
                ]);

                Route::post('sogetrel/mission-proposal/store', [
                    'uses' => "ProposalController@store",
                    'as'   => "sogetrel.mission.proposal.store",
                ]);

                Route::get('sogetrel/mission-proposal/offer/{offer}/store-all', [
                    'uses' => "ProposalController@storeAll",
                    'as'   => "sogetrel.mission.proposal.store.all",
                ]);

                Route::get('sogetrel/mission-proposal/{proposal}/bpu/create', [
                    'uses' => "ProposalController@createBpu",
                    'as'   => "sogetrel.mission.proposal.bpu.create",
                ]);

                Route::post('sogetrel/mission-proposal/{proposal}/bpu/store', [
                    'uses' => "ProposalController@storeBpu",
                    'as'   => "sogetrel.mission.proposal.bpu.store",
                ]);
            });
    }

    public function mapMissionTrackingLineAttachment()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "/sogetrel/mission-tracking-line-attachment";

                Route::get("{$base}", [
                    'uses' => "MissionTrackingLineAttachmentController@index",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.index",
                ]);

                Route::get("{$base}/create", [
                    'uses' => "MissionTrackingLineAttachmentController@create",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.create",
                ]);

                Route::get("{$base}/get-vendors", [
                    'uses' => "MissionTrackingLineAttachmentController@getVendors",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.get_vendors",
                ]);

                Route::get("{$base}/get-missions", [
                    'uses' => "MissionTrackingLineAttachmentController@getMissions",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.get_missions",
                ]);

                Route::get("{$base}/get-milestones", [
                    'uses' => "MissionTrackingLineAttachmentController@getMilestones",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.get_milestones",
                ]);

                Route::post("{$base}/create", [
                    'uses' => "MissionTrackingLineAttachmentController@store",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.store",
                ]);

                Route::get("{$base}/{mission_tracking_line_attachment}", [
                    'uses' => "MissionTrackingLineAttachmentController@show",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.show",
                ]);

                Route::get("{$base}/{mission_tracking_line_attachment}/edit", [
                    'uses' => "MissionTrackingLineAttachmentController@edit",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.edit",
                ]);

                Route::put("{$base}/{mission_tracking_line_attachment}", [
                    'uses' => "MissionTrackingLineAttachmentController@update",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.update",
                ]);

                Route::delete("{$base}/{mission_tracking_line_attachment}", [
                    'uses' => "MissionTrackingLineAttachmentController@delete",
                    'as'   => "sogetrel.mission.mission_tracking_line_attachment.delete",
                ]);
            });
    }
}
