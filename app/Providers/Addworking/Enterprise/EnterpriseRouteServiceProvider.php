<?php

namespace App\Providers\Addworking\Enterprise;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Addworking\Enterprise';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapLegalFormRoutes();
        $this->mapEnterpriseRoutes();
        $this->mapDocumentRoutes();
        $this->mapMemberRoutes();
        $this->mapVendorRoutes();
        $this->mapVendorsBillingDeadlinesRoutes();
        $this->mapMemberInvitationRoutes();
        $this->mapVendorInvitationRoutes();
        $this->mapInvitationRoutes();
        $this->mapReferentRoutes();
    }

    protected function mapLegalFormRoutes()
    {
        Route::middleware(['web'])
            ->namespace('App\Http\Controllers\Support\Enterprise')
            ->name('addworking.')
            ->prefix('addworking/')
            ->group(function () {
                Route::post('enterprise/get-available-legal-forms', [
                    'uses' => 'LegalFormController@getAvailableLegalForms',
                    'as' => 'enterprise.get_available_legal_forms'
                ]);
            });
    }

    protected function mapVendorInvitationRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->name('addworking.')
            ->prefix('addworking/')
            ->group(function () {
                Route::post('enterprise/vendor/invitation/accept', [
                    'uses' => 'VendorInvitationController@accept',
                    'as' => 'enterprise.vendor.invitation.accept'
                ]);

                Route::get('enterprise/vendor/invitation/review', [
                    'uses' => 'VendorInvitationController@review',
                    'as' => 'enterprise.vendor.invitation.review'
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->name('addworking.')
            ->prefix('addworking/')
            ->group(function () {
                Route::get('enterprise/{enterprise}/vendor/invitation/create', [
                    'uses' => 'VendorInvitationController@create',
                    'as' => 'enterprise.vendor.invitation.create'
                ]);

                Route::post('enterprise/{enterprise}/vendor/invitation/store', [
                    'uses' => 'VendorInvitationController@store',
                    'as' => 'enterprise.vendor.invitation.store'
                ]);
            });
    }

    protected function mapMemberInvitationRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->name('addworking.')
            ->prefix('addworking/')
            ->group(function () {
                Route::post('enterprise/member/invitation/accept', [
                    'uses' => 'EnterpriseMemberInvitationController@accept',
                    'as' => 'enterprise.member.invitation.accept'
                ]);

                Route::get('enterprise/member/invitation/review', [
                    'uses' => 'EnterpriseMemberInvitationController@review',
                    'as' => 'enterprise.member.invitation.review'
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->name('addworking.')
            ->prefix('addworking/')
            ->group(function () {
                Route::get('enterprise/{enterprise}/member/invitation/create', [
                    'uses' => 'EnterpriseMemberInvitationController@create',
                    'as' => 'enterprise.member.invitation.create'
                ]);

                Route::post('enterprise/{enterprise}/member/invitation/store', [
                    'uses' => 'EnterpriseMemberInvitationController@store',
                    'as' => 'enterprise.member.invitation.store'
                ]);
            });
    }

    protected function mapInvitationRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->prefix('addworking/')
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/invitation/response', [
                    'uses' => 'InvitationController@response',
                    'as' => 'enterprise.invitation.response'
                ]);

                Route::get('enterprise/invitation/accept', [
                    'uses' => 'InvitationController@response',
                    'as' => 'enterprise.invitation.response'
                ]);

                Route::get('enterprise/invitation/refuse', [
                    'uses' => 'InvitationController@refuse',
                    'as' => 'enterprise.invitation.refuse'
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking')
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/{enterprise}/invitation', [
                    'uses' => 'InvitationController@index',
                    'as' => 'enterprise.invitation.index'
                ]);

                Route::get('enterprise/{enterprise}/invitation/relaunch', [
                    'uses' => 'InvitationController@indexRelaunch',
                    'as' => 'enterprise.invitation.index_relaunch'
                ]);

                Route::get('enterprise/{enterprise}/invitation/{invitation}', [
                    'uses' => 'InvitationController@show',
                    'as' => 'enterprise.invitation.show'
                ]);

                Route::post('enterprise/{enterprise}/invitation/relaunch-multiple', [
                    'uses' => 'InvitationController@relaunchMultiple',
                    'as' => 'enterprise.invitation.relaunch_multiple'
                ]);

                Route::delete('enterprise/{enterprise}/invitation/{invitation}/destroy', [
                    'uses' => 'InvitationController@destroy',
                    'as' => 'enterprise.invitation.destroy'
                ]);

                Route::get('enterprise/{enterprise}/invitation/{invitation}/relaunch', [
                    'uses' => 'InvitationController@relaunch',
                    'as' => 'enterprise.invitation.relaunch'
                ]);
            });
    }

    public function mapMemberRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/{enterprise}/member', [
                    'uses' => 'EnterpriseMemberController@index',
                    'as' => 'enterprise.member.index'
                ]);

                Route::get('enterprise/{enterprise}/member/create', [
                    'uses' => 'EnterpriseMemberController@create',
                    'as' => 'enterprise.member.create'
                ]);

                Route::post('enterprise/{enterprise}/member/store', [
                    'uses' => 'EnterpriseMemberController@store',
                    'as' => 'enterprise.member.store'
                ]);

                Route::get('enterprise/{enterprise}/member/{user}/show', [
                    'uses' => 'EnterpriseMemberController@show',
                    'as' => 'enterprise.member.show'
                ]);

                Route::get('enterprise/{enterprise}/member/{user}/edit', [
                    'uses' => 'EnterpriseMemberController@edit',
                    'as' => 'enterprise.member.edit'
                ]);

                Route::post('enterprise/{enterprise}/member/{user}/update', [
                    'uses' => 'EnterpriseMemberController@update',
                    'as' => 'enterprise.member.update'
                ]);

                Route::delete('enterprise/{enterprise}/member/{user}/remove', [
                    'uses' => 'EnterpriseMemberController@remove',
                    'as' => 'enterprise.member.remove'
                ]);
            });
    }

    public function mapEnterpriseRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/create-cps2', [
                    'uses' => 'EnterpriseController@createCps2',
                    'as'   => 'enterprise.create_cps2',
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking')
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/{enterprise}/documents/download', [
                    'uses' => 'EnterpriseController@downloadDocuments',
                    'as'   => 'enterprise.download_documents'
                ]);

                Route::get('enterprise/{enterprise}/create-cps2', [
                    'uses' => 'EnterpriseController@createCps2',
                    'as'   => 'enterprise.create_cps2',
                ]);

                Route::resource('enterprise.phone_number', 'EnterprisePhoneNumberController')
                    ->only(['create', 'store', 'destroy']);

                Route::resource('enterprise.site', 'SiteController');

                Route::resource('enterprise.site.phone_number', 'SitePhoneNumberController')
                    ->only(['create', 'store', 'destroy']);

                Route::resource('enterprise.phone_number', 'EnterprisePhoneNumberController')
                    ->only(['create', 'store', 'destroy']);
            });
    }

    protected function mapVendorRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/vendor', [
                    'uses' => "VendorController@index",
                    'as'   => "addworking.enterprise.vendor.index"
                ]);

                Route::get('enterprise/{enterprise}/vendor/index-division-by-skills', [
                    'uses' => "VendorController@indexDivisionBySkills",
                    'as'   => "addworking.enterprise.vendor.index_division_by_skills"
                ]);

                Route::get('enterprise/{enterprise}/vendor/attach', [
                    'uses' => "VendorController@attach",
                    'as'   => "addworking.enterprise.vendor.attach"
                ]);

                Route::post('enterprise/{enterprise}/vendor/attach/store', [
                    'uses' => "VendorController@storeAttach",
                    'as'   => "addworking.enterprise.vendor.attach.store"
                ]);

                Route::get('enterprise/{enterprise}/vendor/export', [
                    'uses' => "VendorController@export",
                    'as'   => "addworking.enterprise.vendor.export"
                ]);

                Route::get('enterprise/{enterprise}/vendor/import', [
                    'uses' => "VendorController@import",
                    'as'   => "addworking.enterprise.vendor.import",
                ]);

                Route::post('enterprise/{enterprise}/vendor/load', [
                    'uses' => "VendorController@load",
                    'as'   => "addworking.enterprise.vendor.load",
                ]);

                Route::get('enterprise/{enterprise}/vendor/{vendor}/detach', [
                    'uses' => "VendorController@detach",
                    'as'   => "addworking.enterprise.vendor.detach"
                ]);

                Route::get('enterprise/{enterprise}/vendor/{vendor}/partnership/edit', [
                    'uses' => "VendorController@editPartnership",
                    'as'   => "addworking.enterprise.vendor.partnership.edit"
                ]);

                Route::put('enterprise/{enterprise}/vendor/{vendor}/partnership/update', [
                    'uses' => "VendorController@updatePartnership",
                    'as'   => "addworking.enterprise.vendor.partnership.update"
                ]);
            });
    }

    protected function mapVendorsBillingDeadlinesRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/vendor/{vendor}/billing-deadline', [
                    'uses' => "VendorsBillingDeadlinesController@index",
                    'as' => "addworking.enterprise.vendor.billing_deadline.index"
                ]);

                Route::get('enterprise/{enterprise}/vendor/{vendor}/billing-deadline/edit', [
                    'uses' => "VendorsBillingDeadlinesController@edit",
                    'as' => "addworking.enterprise.vendor.billing_deadline.edit"
                ]);

                Route::put('enterprise/{enterprise}/vendor/{vendor}/billing-deadline', [
                    'uses' => "VendorsBillingDeadlinesController@update",
                    'as' => "addworking.enterprise.vendor.billing_deadline.update"
                ]);
            });
    }

    protected function mapDocumentRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking')
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/{enterprise}/document/zip', [
                    'uses' => 'DocumentController@zip',
                    'as'   => 'enterprise.document.zip',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/download', [
                    'uses' => 'DocumentController@download',
                    'as'   => 'enterprise.document.download',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/replace', [
                    'uses' => 'DocumentController@replace',
                    'as'   => 'enterprise.document.replace',
                ]);

                Route::post('enterprise/{enterprise}/document/{document}/replace', [
                    'uses' => 'DocumentController@storeReplace',
                    'as'   => 'enterprise.document.store_replace',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/accept', [
                    'uses' => 'DocumentController@accept',
                    'as'   => 'enterprise.document.accept',
                ]);

                Route::patch('enterprise/{enterprise}/document/{document}/accept', [
                    'uses' => 'DocumentController@storeAccept',
                    'as'   => 'enterprise.document.store_accept',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/reject', [
                    'uses' => 'DocumentController@reject',
                    'as'   => 'enterprise.document.reject',
                ]);

                Route::patch('enterprise/{enterprise}/document/{document}/reject', [
                    'uses' => 'DocumentController@storeReject',
                    'as'   => 'enterprise.document.store_reject',
                ]);

                Route::post('enterprise/{enterprise}/document-type/{type}/model/store', [
                    'uses' => "DocumentTypeController@modelStore",
                    'as'   => "enterprise.document-type.model_store",
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/tag', [
                    'uses' => 'DocumentController@tag',
                    'as'   => 'enterprise.document.tag'
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/untag', [
                    'uses' => 'DocumentController@untag',
                    'as'   => 'enterprise.document.untag'
                ]);

                Route::get('enterprise/{enterprise}/document/document_type/{document_type}/history', [
                    'uses' => 'DocumentController@history',
                    'as'   => 'enterprise.document.history',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/show-trashed', [
                    'uses' => 'DocumentController@showTrashed',
                    'as'   => 'enterprise.document.show_trashed',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/show-pre-check', [
                    'uses' => "DocumentController@storePreCheck",
                    'as'   => "enterprise.document.show_pre_check",
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/show-no-pre-check', [
                    'uses' => "DocumentController@removePreCheck",
                    'as'   => "enterprise.document.show_no_pre_check",
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/actions-history', [
                    'uses' => 'DocumentController@documentActionsHistory',
                    'as'   => 'enterprise.document.actions_history',
                ]);

                Route::get('enterprise/{enterprise}/document/choose-model/document-type/{document_type}', [
                    'uses' => 'DocumentController@chooseModel',
                    'as'   => 'enterprise.document.choose_model',
                ]);

                Route::post('enterprise/{enterprise}/document/generate-model/document-type/{document_type}', [
                    'uses' => 'DocumentController@generateModel',
                    'as'   => 'enterprise.document.generate_model',
                ]);

                Route::get('enterprise/{enterprise}/document-model/{document}', [
                    'uses' => 'DocumentController@showModel',
                    'as'   => 'enterprise.document.show_model',
                ]);

                Route::get('enterprise/{enterprise}/document-model/{document}/sign', [
                    'uses' => 'DocumentController@sign',
                    'as'   => 'enterprise.document.sign',
                ]);

                Route::resource('enterprise.document', 'DocumentController');

                Route::get('enterprise/{enterprise}/document/document-type/{document_type}/create-from', [
                    'uses' => 'DocumentController@createFrom',
                    'as'   => 'enterprise.document.create_from',
                ]);

                Route::resource('enterprise.document-type', 'DocumentTypeController')
                    ->parameters(['document-type' => 'type']);

                Route::resource('enterprise.document-type.field', 'DocumentTypeFieldController')
                    ->only(['store', 'update', 'destroy'])
                    ->parameters(['document-type' => 'type']);

                Route::get('enterprise/{enterprise}/document/{document}/proof-authenticity/create', [
                    'uses' => 'DocumentProofAuthenticityController@create',
                    'as'   => 'enterprise.document.proof_authenticity.create',
                ]);

                Route::post('enterprise/{enterprise}/document/{document}/proof-authenticity/store', [
                    'uses' => 'DocumentProofAuthenticityController@store',
                    'as'   => 'enterprise.document.proof_authenticity.store',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/proof-authenticity/download', [
                    'uses' => 'DocumentProofAuthenticityController@download',
                    'as'   => 'enterprise.document.proof_authenticity.download',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/proof-authenticity/download-from-yousign', [
                    'uses' => 'DocumentProofAuthenticityController@downloadFromYousign',
                    'as'   => 'enterprise.document.proof_authenticity.download_from_yousign',
                ]);

                Route::get('enterprise/{enterprise}/document/{document}/proof-authenticity/edit', [
                    'uses' => 'DocumentProofAuthenticityController@edit',
                    'as'   => 'enterprise.document.proof_authenticity.edit',
                ]);

                Route::post('enterprise/{enterprise}/document/{document}/proof-authenticity/update', [
                    'uses' => 'DocumentProofAuthenticityController@update',
                    'as'   => 'enterprise.document.proof_authenticity.update',
                ]);
            });
    }

    protected function mapReferentRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking')
            ->name('addworking.')
            ->group(function () {
                Route::get('enterprise/{enterprise}/member/{user}/vendor/edit', [
                    'uses' => 'EnterpriseReferentController@editAssignedVendors',
                    'as' => 'enterprise.referent.assigned_vendor.edit'
                ]);

                Route::post('enterprise/{enterprise}/member/{user}/vendor/update', [
                    'uses' => 'EnterpriseReferentController@updateAssignedVendors',
                    'as' => 'enterprise.referent.assigned_vendor.update'
                ]);
            });
    }
}
