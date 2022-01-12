<?php

namespace Components\Enterprise\Document\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class DocumentRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\Document\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapDocumentModelRoutes();
        $this->mapDocumentTypeRejectReasonRoutes();
    }

    private function mapDocumentModelRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/document/model";

                Route::post("{$base}/generate/", [
                    'uses' => 'DocumentModelController@generateDocumentModel',
                    'as' => 'enterprise.document.model.generate',
                ]);

                Route::get("{$base}/{document}/sign", [
                    'uses' => 'DocumentModelController@sign',
                    'as' => 'enterprise.document.model.sign',
                ]);

                Route::get("{$base}/{document}", [
                    'uses' => 'DocumentModelController@show',
                    'as' => 'enterprise.document.model.show',
                ]);

                Route::get("{$base}/{document}/add-required-document", [
                    'uses' => 'DocumentModelController@addRequiredDocument',
                    'as' => 'enterprise.document.model.add_required_document',
                ]);

                Route::post("{$base}/{document}/store-required-document", [
                    'uses' => 'DocumentModelController@storeRequiredDocument',
                    'as' => 'enterprise.document.model.store_required_document',
                ]);
            });

        Route::namespace($this->namespace)
            ->group(function () {
                Route::get("document/callback/procedure-refused", [
                    'uses' => 'DocumentModelController@callbackProcedureRefused',
                    'as' => 'enterprise.document.model.callback.procedure_refused'
                ]);

                Route::get("document/callback/procedure-finished", [
                    'uses' => 'DocumentModelController@callbackProcedureFinished',
                    'as' => 'enterprise.document.model.callback.procedure_finished'
                ]);
            });
    }

    private function mapDocumentTypeRejectReasonRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/document_type/{document_type}/document_type_reject_reason";

                Route::get("{$base}/", [
                    'uses' => 'DocumentTypeRejectReasonController@index', 'as' => 'document_type_reject_reason.index'
                ]);

                Route::post("{$base}/get_available_reject_reason_ajax", [
                    'uses' => 'DocumentTypeRejectReasonController@getAvailableRejectReasonAjax',
                    'as' => 'document_type_reject_reason.get_available_reject_reason_ajax'
                ]);

                Route::delete("{$base}/{document_type_reject_reason}/delete", [
                    'uses' => 'DocumentTypeRejectReasonController@delete', 'as' => 'document_type_reject_reason.delete'
                ]);
 
                Route::get("{$base}/create", [
                    'uses' => 'DocumentTypeRejectReasonController@create', 'as' => 'document_type_reject_reason.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'DocumentTypeRejectReasonController@store', 'as' => 'document_type_reject_reason.store'
                ]);

                Route::get("{$base}/{document_type_reject_reason}/edit", [
                    'uses' => 'DocumentTypeRejectReasonController@edit', 'as' => 'document_type_reject_reason.edit'
                ]);

                Route::put("{$base}/{document_type_reject_reason}/update", [
                    'uses' => 'DocumentTypeRejectReasonController@update', 'as' => 'document_type_reject_reason.update'
                ]);
            });
    }
}
