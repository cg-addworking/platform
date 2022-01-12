<?php

namespace Components\Contract\Model\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ContractModelRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Contract\Model\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapContractModelSupportRoutes();
        $this->mapContractModelPartySupportRoutes();
        $this->mapContractModelPartyDocumentTypeSupportRoutes();
        $this->mapContractModelPartSupportRoutes();
        $this->mapContractModelVariableSupportRoutes();
    }

    private function mapContractModelSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract-model";

                Route::get("{$base}/", [
                    'uses' => 'ContractModelController@index', 'as' => 'contract.model.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'ContractModelController@create', 'as' => 'contract.model.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractModelController@store', 'as' => 'contract.model.store'
                ]);

                Route::get("{$base}/{contract_model}", [
                    'uses' => 'ContractModelController@show', 'as' => 'contract.model.show'
                ]);

                Route::get("{$base}/{contract_model}/edit", [
                    'uses' => 'ContractModelController@edit', 'as' => 'contract.model.edit'
                ]);

                Route::put("{$base}/{contract_model}/update", [
                    'uses' => 'ContractModelController@update', 'as' => 'contract.model.update'
                ]);

                Route::delete("{$base}/{contract_model}/delete", [
                    'uses' => 'ContractModelController@delete', 'as' => 'contract.model.delete'
                ]);

                Route::put("{$base}/{contract_model}/publish", [
                    'uses' => 'ContractModelController@publish', 'as' => 'contract.model.publish'
                ]);

                Route::get("{$base}/{contract_model}/duplicate", [
                    'uses' => 'ContractModelController@duplicate', 'as' => 'contract.model.duplicate'
                ]);

                Route::put("{$base}/{contract_model}/unpublish", [
                    'uses' => 'ContractModelController@unpublish', 'as' => 'contract.model.unpublish'
                ]);

                Route::get("{$base}/{contract_model}/versionning", [
                    'uses' => 'ContractModelController@versionate', 'as' => 'contract.model.versionate'
                ]);

                Route::get("{$base}/{contract_model}/archive", [
                    'uses' => 'ContractModelController@archive', 'as' => 'contract.model.archive'
                ]);
            });
    }

    private function mapContractModelPartyDocumentTypeSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract-model/{contract_model}/party/{contract_model_party}";

                Route::get("{$base}/document-type/", [
                    'uses' => 'ContractModelPartyDocumentTypeController@index',
                    'as' => 'contract.model.party.document_type.index'
                ]);

                Route::get("{$base}/document-type/create-specific-document", [
                    'uses' => 'ContractModelPartyDocumentTypeController@createSpecificDocument',
                    'as' => 'contract.model.party.document_type.create_specific_document'
                ]);
                
                Route::post("{$base}/document-type/store-specific-document", [
                    'uses' => 'ContractModelPartyDocumentTypeController@storeSpecificDocument',
                    'as' => 'contract.model.party.document_type.store_specific_document'
                ]);

                Route::get("{$base}/document-type/create", [
                    'uses' => 'ContractModelPartyDocumentTypeController@create',
                    'as' => 'contract.model.party.document_type.create'
                ]);

                Route::post("{$base}/document-type/store", [
                    'uses' => 'ContractModelPartyDocumentTypeController@store',
                    'as' => 'contract.model.party.document_type.store'
                ]);

                Route::delete("{$base}/document-type/{contract_model_document_type}/delete", [
                    'uses' => 'ContractModelPartyDocumentTypeController@delete',
                    'as' => 'contract.model.party.document_type.delete'
                ]);
            });
    }

    private function mapContractModelPartySupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract-model/{contract_model}/contract-model-party";

                Route::delete("{$base}/{contract_model_party}/delete", [
                    'uses' => 'ContractModelPartyController@delete', 'as' => 'contract.model.party.delete'
                ]);
            });
    }

    private function mapContractModelPartSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract-model/{contract_model}/contract-model-part";

                Route::get($base, [
                    'uses' => 'ContractModelPartController@index', 'as' => 'contract.model.part.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'ContractModelPartController@create', 'as' => 'contract.model.part.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractModelPartController@store', 'as' => 'contract.model.part.store'
                ]);

                Route::get("{$base}/{contract_model_part}/edit", [
                    'uses' => 'ContractModelPartController@edit', 'as' => 'contract.model.part.edit'
                ]);

                Route::put("{$base}/{contract_model_part}/update", [
                    'uses' => 'ContractModelPartController@update', 'as' => 'contract.model.part.update'
                ]);

                Route::delete("{$base}/{contract_model_part}/delete", [
                    'uses' => 'ContractModelPartController@delete', 'as' => 'contract.model.part.delete'
                ]);

                Route::get("{$base}/{contract_model_part}/preview", [
                    'uses' => 'ContractModelPartController@preview', 'as' => 'contract.model.part.preview'
                ]);

                Route::post("{$base}/preview-wysiwyg", [
                    'uses' => 'ContractModelPartController@wysiwygPreview',
                    'as' => 'contract.model.part.wysiwyg_preview'
                ]);
            });
    }

    private function mapContractModelVariableSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract-model/{contract_model}/contract-model-variable";

                Route::get($base, [
                    'uses' => 'ContractModelVariableController@index', 'as' => 'contract.model.variable.index'
                ]);

                Route::get("{$base}/edit", [
                    'uses' => 'ContractModelVariableController@edit', 'as' => 'contract.model.variable.edit'
                ]);

                Route::put("{$base}/update", [
                    'uses' => 'ContractModelVariableController@update', 'as' => 'contract.model.variable.update'
                ]);
            });
    }
}
