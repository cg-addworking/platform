<?php

namespace App\Providers\Support\Enterprise;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Support\Enterprise';

    public function map()
    {
        $this->mapLegalForm();

        $this->mapDocumentType();

        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                Route::get('omnisearch', [
                    'uses' => "OmnisearchController@index",
                    'as'   => "enterprise.omnisearch.index",
                ]);

                Route::post('omnisearch', [
                    'uses' => "OmnisearchController@search",
                    'as'   => "enterprise.omnisearch.search",
                ]);

                Route::get('document', [
                    'uses' => "DocumentController@index",
                    'as'   => "enterprise.document.index",
                ]);

                Route::get('document/export', [
                    'uses' => "DocumentController@export",
                    'as'   => "enterprise.document.export"
                ]);
            });
    }

    public function mapLegalForm()
    {
        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::post('support/legal-form', [
                    'uses' => "LegalFormController@store",
                    'as'   => "support.enterprise.legal_form.store",
                ]);

                Route::get('support/legal-form', [
                    'uses' => "LegalFormController@index",
                    'as'   => "support.enterprise.legal_form.index",
                ]);

                Route::get('support/legal-form/create', [
                    'uses' => "LegalFormController@create",
                    'as'   => "support.enterprise.legal_form.create",
                ]);

                Route::get('support/legal-form/{legal_form}', [
                    'uses' => "LegalFormController@show",
                    'as'   => "support.enterprise.legal_form.show",
                ]);

                Route::get('support/legal-form/{legal_form}/edit', [
                    'uses' => "LegalFormController@edit",
                    'as'   => "support.enterprise.legal_form.edit",
                ]);

                Route::put('support/legal-form/{legal_form}', [
                    'uses' => "LegalFormController@update",
                    'as'   => "support.enterprise.legal_form.update",
                ]);

                Route::delete('support/legal-form/{legal_form}', [
                    'uses' => "LegalFormController@destroy",
                    'as'   => "support.enterprise.legal_form.destroy",
                ]);
            });
    }

    public function mapDocumentType()
    {
        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                Route::get('document_type', [
                    'uses' => "DocumentTypeController@index",
                    'as'   => "enterprise.document_type.index",
                ]);
            });
    }
}
