<?php

namespace App\Providers\Addworking\Contract;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ContractRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Addworking\Contract';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapLegacy();
        $this->mapContractAnnex();
        $this->mapContractDocument();
        $this->mapContractVariable();
        $this->mapContractParty();
        $this->mapContractPartyDocumentType();
        $this->mapContract();
        $this->mapContractTemplateAnnex();
        $this->mapContractTemplateParty();
        $this->mapContractTemplatePartyDocumentType();
        $this->mapContractTemplateVariable();
        $this->mapContractTemplate();
    }

    public function mapLegacy()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('addworking/contracts', [
                    'uses' => "ContractController@dispatcher",
                    'as'   => "contract.index",
                ]);
            });
    }

    public function mapContract()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('addworking/contract', [
                    'uses' => "ContractController@dispatcher",
                    'as'   => "addworking.contract.contract.dispatcher",
                ]);

                $base = "addworking/enterprise/{enterprise}";

                Route::get("{$base}/contract", [
                    'uses' => "ContractController@index",
                    'as'   => "addworking.contract.contract.index",
                ]);

                Route::get("{$base}/contract/create", [
                    'uses' => "ContractController@create",
                    'as'   => "addworking.contract.contract.create",
                ]);

                Route::get("{$base}/contract/create-blank", [
                    'uses' => "ContractController@createBlank",
                    'as'   => "addworking.contract.contract.create_blank",
                ]);

                Route::post("{$base}/contract/create-blank", [
                    'uses' => "ContractController@createBlankPost",
                    'as'   => "addworking.contract.contract.create_blank_post",
                ]);

                Route::get("{$base}/contract/create-from-existing-file", [
                    'uses' => "ContractController@createFromExistingFile",
                    'as'   => "addworking.contract.contract.create_from_existing_file",
                ]);

                Route::post("{$base}/contract/create-from-existing-file", [
                    'uses' => "ContractController@createFromExistingFilePost",
                    'as'   => "addworking.contract.contract.create_from_existing_file_post",
                ]);

                Route::get("{$base}/contract/create-from-template", [
                    'uses' => "ContractController@createFromTemplate",
                    'as'   => "addworking.contract.contract.create_from_template",
                ]);

                Route::post("{$base}/contract/create-from-template", [
                    'uses' => "ContractController@createFromTemplatePost",
                    'as'   => "addworking.contract.contract.create_from_template_post",
                ]);

                Route::post("{$base}/contract", [
                    'uses' => "ContractController@store",
                    'as'   => "addworking.contract.contract.store",
                ]);

                Route::get("{$base}/contract/{contract}", [
                    'uses' => "ContractController@show",
                    'as'   => "addworking.contract.contract.show",
                ]);

                Route::get("{$base}/contract/{contract}/edit", [
                    'uses' => "ContractController@edit",
                    'as'   => "addworking.contract.contract.edit",
                ]);

                Route::put("{$base}/contract/{contract}", [
                    'uses' => "ContractController@update",
                    'as'   => "addworking.contract.contract.update",
                ]);

                Route::delete("{$base}/contract/{contract}", [
                    'uses' => "ContractController@destroy",
                    'as'   => "addworking.contract.contract.destroy",
                ]);

                Route::get("{$base}/contract/{contract}/addendum/create", [
                    'uses' => "ContractController@createAddendum",
                    'as'   => "addworking.contract.contract.create_addendum",
                ]);

                Route::post("{$base}/contract/{contract}/addendum", [
                    'uses' => "ContractController@storeAddendum",
                    'as'   => "addworking.contract.contract.store_addendum",
                ]);
            });
    }

    public function mapContractAnnex()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract/{contract}";

                Route::get("{$base}/annex", [
                    'uses' => "ContractAnnexController@index",
                    'as'   => "addworking.contract.contract_annex.index",
                ]);

                Route::get("{$base}/annex/create", [
                    'uses' => "ContractAnnexController@create",
                    'as'   => "addworking.contract.contract_annex.create",
                ]);

                Route::post("{$base}/annex", [
                    'uses' => "ContractAnnexController@store",
                    'as'   => "addworking.contract.contract_annex.store",
                ]);

                Route::get("{$base}/annex/{contract_annex}", [
                    'uses' => "ContractAnnexController@show",
                    'as'   => "addworking.contract.contract_annex.show",
                ]);

                Route::get("{$base}/annex/{contract_annex}/edit", [
                    'uses' => "ContractAnnexController@edit",
                    'as'   => "addworking.contract.contract_annex.edit",
                ]);

                Route::put("{$base}/annex/{contract_annex}", [
                    'uses' => "ContractAnnexController@update",
                    'as'   => "addworking.contract.contract_annex.update",
                ]);

                Route::delete("{$base}/annex/{contract_annex}", [
                    'uses' => "ContractAnnexController@destroy",
                    'as'   => "addworking.contract.contract_annex.destroy",
                ]);
            });
    }

    public function mapContractDocument()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract/{contract}/party/{contract_party}";

                Route::get("{$base}/document", [
                    'uses' => "ContractDocumentController@index",
                    'as'   => "addworking.contract.contract_document.index",
                ]);

                Route::get("{$base}/document/create", [
                    'uses' => "ContractDocumentController@create",
                    'as'   => "addworking.contract.contract_document.create",
                ]);

                Route::post("{$base}/document", [
                    'uses' => "ContractDocumentController@store",
                    'as'   => "addworking.contract.contract_document.store",
                ]);

                Route::get("{$base}/document/{contract_document}", [
                    'uses' => "ContractDocumentController@show",
                    'as'   => "addworking.contract.contract_document.show",
                ]);

                Route::get("{$base}/document/{contract_document}/edit", [
                    'uses' => "ContractDocumentController@edit",
                    'as'   => "addworking.contract.contract_document.edit",
                ]);

                Route::put("{$base}/document/{contract_document}", [
                    'uses' => "ContractDocumentController@update",
                    'as'   => "addworking.contract.contract_document.update",
                ]);

                Route::delete("{$base}/document/{contract_document}", [
                    'uses' => "ContractDocumentController@destroy",
                    'as'   => "addworking.contract.contract_document.destroy",
                ]);
            });
    }

    public function mapContractParty()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract/{contract}";

                Route::get("{$base}/party", [
                    'uses' => "ContractPartyController@index",
                    'as'   => "addworking.contract.contract_party.index",
                ]);

                Route::get("{$base}/party/create", [
                    'uses' => "ContractPartyController@create",
                    'as'   => "addworking.contract.contract_party.create",
                ]);

                Route::post("{$base}/party", [
                    'uses' => "ContractPartyController@store",
                    'as'   => "addworking.contract.contract_party.store",
                ]);

                Route::get("{$base}/party/{contract_party}", [
                    'uses' => "ContractPartyController@show",
                    'as'   => "addworking.contract.contract_party.show",
                ]);

                Route::get("{$base}/party/{contract_party}/edit", [
                    'uses' => "ContractPartyController@edit",
                    'as'   => "addworking.contract.contract_party.edit",
                ]);

                Route::put("{$base}/party/{contract_party}", [
                    'uses' => "ContractPartyController@update",
                    'as'   => "addworking.contract.contract_party.update",
                ]);

                Route::delete("{$base}/party/{contract_party}", [
                    'uses' => "ContractPartyController@destroy",
                    'as'   => "addworking.contract.contract_party.destroy",
                ]);

                Route::get("{$base}/party/{contract_party}/assign-signatory", [
                    'uses' => "ContractPartyController@assignSignatory",
                    'as'   => "addworking.contract.contract_party.assign_signatory",
                ]);

                Route::put("{$base}/party/{contract_party}/assign-signatory", [
                    'uses' => "ContractPartyController@assignSignatoryPut",
                    'as'   => "addworking.contract.contract_party.assign_signatory_put",
                ]);

                Route::get("{$base}/party/{contract_party}/dissociate-signatory", [
                    'uses' => "ContractPartyController@dissociateSignatory",
                    'as'   => "addworking.contract.contract_party.dissociate_signatory",
                ]);
            });
    }

    public function mapContractPartyDocumentType()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract/{contract}/party/{contract_party}";

                Route::get("{$base}/document-type", [
                    'uses' => "ContractPartyDocumentTypeController@index",
                    'as'   => "addworking.contract.contract_party_document_type.index",
                ]);

                Route::get("{$base}/document-type/create", [
                    'uses' => "ContractPartyDocumentTypeController@create",
                    'as'   => "addworking.contract.contract_party_document_type.create",
                ]);

                Route::post("{$base}/document-type", [
                    'uses' => "ContractPartyDocumentTypeController@store",
                    'as'   => "addworking.contract.contract_party_document_type.store",
                ]);

                Route::get("{$base}/document-type/{contract_party_document_type}", [
                    'uses' => "ContractPartyDocumentTypeController@show",
                    'as'   => "addworking.contract.contract_party_document_type.show",
                ]);

                Route::get("{$base}/document-type/{contract_party_document_type}/edit", [
                    'uses' => "ContractPartyDocumentTypeController@edit",
                    'as'   => "addworking.contract.contract_party_document_type.edit",
                ]);

                Route::put("{$base}/document-type/{contract_party_document_type}", [
                    'uses' => "ContractPartyDocumentTypeController@update",
                    'as'   => "addworking.contract.contract_party_document_type.update",
                ]);

                Route::delete("{$base}/document-type/{contract_party_document_type}", [
                    'uses' => "ContractPartyDocumentTypeController@destroy",
                    'as'   => "addworking.contract.contract_party_document_type.destroy",
                ]);

                Route::get("{$base}/document-type/{contract_party_document_type}/attach-existing-document", [
                    'uses' => "ContractPartyDocumentTypeController@attachExistingDocument",
                    'as'   => "addworking.contract.contract_party_document_type.attach_existing_document",
                ]);

                Route::post("{$base}/document-type/{contract_party_document_type}/attach-existing-document", [
                    'uses' => "ContractPartyDocumentTypeController@attachExistingDocumentPost",
                    'as'   => "addworking.contract.contract_party_document_type.attach_existing_document_post",
                ]);

                Route::get("{$base}/document-type/{contract_party_document_type}/attach-new-document", [
                    'uses' => "ContractPartyDocumentTypeController@attachNewDocument",
                    'as'   => "addworking.contract.contract_party_document_type.attach_new_document",
                ]);

                Route::post("{$base}/document-type/{contract_party_document_type}/attach-new-document", [
                    'uses' => "ContractPartyDocumentTypeController@attachNewDocumentPost",
                    'as'   => "addworking.contract.contract_party_document_type.attach_new_document_post",
                ]);

                Route::get("{$base}/document-type/{contract_party_document_type}/detach-document", [
                    'uses' => "ContractPartyDocumentTypeController@detachDocument",
                    'as'   => "addworking.contract.contract_party_document_type.detach_document",
                ]);
            });
    }

    public function mapContractVariable()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract/{contract}";

                Route::get("{$base}/variable", [
                    'uses' => "ContractVariableController@index",
                    'as'   => "addworking.contract.contract_variable.index",
                ]);

                Route::get("{$base}/variable/create", [
                    'uses' => "ContractVariableController@create",
                    'as'   => "addworking.contract.contract_variable.create",
                ]);

                Route::post("{$base}/variable", [
                    'uses' => "ContractVariableController@store",
                    'as'   => "addworking.contract.contract_variable.store",
                ]);

                Route::get("{$base}/variable/{contract_variable}", [
                    'uses' => "ContractVariableController@show",
                    'as'   => "addworking.contract.contract_variable.show",
                ]);

                Route::get("{$base}/variable/{contract_variable}/edit", [
                    'uses' => "ContractVariableController@edit",
                    'as'   => "addworking.contract.contract_variable.edit",
                ]);

                Route::put("{$base}/variable/{contract_variable}", [
                    'uses' => "ContractVariableController@update",
                    'as'   => "addworking.contract.contract_variable.update",
                ]);

                Route::delete("{$base}/variable/{contract_variable}", [
                    'uses' => "ContractVariableController@destroy",
                    'as'   => "addworking.contract.contract_variable.destroy",
                ]);
            });
    }

    public function mapContractTemplate()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('addworking/enterprise/{enterprise}/contract-template', [
                    'uses' => "ContractTemplateController@index",
                    'as'   => "addworking.contract.contract_template.index",
                ]);

                Route::get('addworking/enterprise/{enterprise}/contract-template/create', [
                    'uses' => "ContractTemplateController@create",
                    'as'   => "addworking.contract.contract_template.create",
                ]);

                Route::post('addworking/enterprise/{enterprise}/contract-template', [
                    'uses' => "ContractTemplateController@store",
                    'as'   => "addworking.contract.contract_template.store",
                ]);

                Route::get('addworking/enterprise/{enterprise}/contract-template/{contract_template}', [
                    'uses' => "ContractTemplateController@show",
                    'as'   => "addworking.contract.contract_template.show",
                ]);

                Route::get('addworking/enterprise/{enterprise}/contract-template/{contract_template}/edit', [
                    'uses' => "ContractTemplateController@edit",
                    'as'   => "addworking.contract.contract_template.edit",
                ]);

                Route::put('addworking/enterprise/{enterprise}/contract-template/{contract_template}', [
                    'uses' => "ContractTemplateController@update",
                    'as'   => "addworking.contract.contract_template.update",
                ]);

                Route::delete('addworking/enterprise/{enterprise}/contract-template/{contract_template}', [
                    'uses' => "ContractTemplateController@destroy",
                    'as'   => "addworking.contract.contract_template.destroy",
                ]);
            });
    }

    public function mapContractTemplateAnnex()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract-template/{contract_template}";

                Route::get("{$base}/annex", [
                    'uses' => "ContractTemplateAnnexController@index",
                    'as'   => "addworking.contract.contract_template_annex.index",
                ]);

                Route::get("{$base}/annex/create", [
                    'uses' => "ContractTemplateAnnexController@create",
                    'as'   => "addworking.contract.contract_template_annex.create",
                ]);

                Route::post("{$base}/annex", [
                    'uses' => "ContractTemplateAnnexController@store",
                    'as'   => "addworking.contract.contract_template_annex.store",
                ]);

                Route::get("{$base}/annex/{contract_template_annex}", [
                    'uses' => "ContractTemplateAnnexController@show",
                    'as'   => "addworking.contract.contract_template_annex.show",
                ]);

                Route::get("{$base}/annex/{contract_template_annex}/edit", [
                    'uses' => "ContractTemplateAnnexController@edit",
                    'as'   => "addworking.contract.contract_template_annex.edit",
                ]);

                Route::put("{$base}/annex/{contract_template_annex}", [
                    'uses' => "ContractTemplateAnnexController@update",
                    'as'   => "addworking.contract.contract_template_annex.update",
                ]);

                Route::delete("{$base}/annex/{contract_template_annex}", [
                    'uses' => "ContractTemplateAnnexController@destroy",
                    'as'   => "addworking.contract.contract_template_annex.destroy",
                ]);
            });
    }

    public function mapContractTemplateParty()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract-template/{contract_template}";

                Route::get("{$base}/party", [
                    'uses' => "ContractTemplatePartyController@index",
                    'as'   => "addworking.contract.contract_template_party.index",
                ]);

                Route::get("{$base}/party/create", [
                    'uses' => "ContractTemplatePartyController@create",
                    'as'   => "addworking.contract.contract_template_party.create",
                ]);

                Route::post("{$base}/party", [
                    'uses' => "ContractTemplatePartyController@store",
                    'as'   => "addworking.contract.contract_template_party.store",
                ]);

                Route::get("{$base}/party/{contract_template_party}", [
                    'uses' => "ContractTemplatePartyController@show",
                    'as'   => "addworking.contract.contract_template_party.show",
                ]);

                Route::get("{$base}/party/{contract_template_party}/edit", [
                    'uses' => "ContractTemplatePartyController@edit",
                    'as'   => "addworking.contract.contract_template_party.edit",
                ]);

                Route::put("{$base}/party/{contract_template_party}", [
                    'uses' => "ContractTemplatePartyController@update",
                    'as'   => "addworking.contract.contract_template_party.update",
                ]);

                Route::delete("{$base}/party/{contract_template_party}", [
                    'uses' => "ContractTemplatePartyController@destroy",
                    'as'   => "addworking.contract.contract_template_party.destroy",
                ]);
            });
    }

    public function mapContractTemplatePartyDocumentType()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking".
                    "/enterprise/{enterprise}".
                    "/contract-template/{contract_template}".
                    "/party/{contract_template_party}";

                Route::get("{$base}/document-type", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@index",
                    'as'   => "addworking.contract.contract_template_party_document_type.index",
                ]);

                Route::get("{$base}/document-type/create", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@create",
                    'as'   => "addworking.contract.contract_template_party_document_type.create",
                ]);

                Route::post("{$base}/document-type", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@store",
                    'as'   => "addworking.contract.contract_template_party_document_type.store",
                ]);

                Route::get("{$base}/document-type/{document_type}", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@show",
                    'as'   => "addworking.contract.contract_template_party_document_type.show",
                ]);

                Route::get("{$base}/document-type/{document_type}/edit", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@edit",
                    'as'   => "addworking.contract.contract_template_party_document_type.edit",
                ]);

                Route::put("{$base}/document-type/{document_type}", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@update",
                    'as'   => "addworking.contract.contract_template_party_document_type.update",
                ]);

                Route::delete("{$base}/document-type/{document_type}", [
                    'uses' => "ContractTemplatePartyDocumentTypeController@destroy",
                    'as'   => "addworking.contract.contract_template_party_document_type.destroy",
                ]);
            });
    }

    public function mapContractTemplateVariable()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/contract-template/{contract_template}/";

                Route::get("{$base}/variable", [
                    'uses' => "ContractTemplateVariableController@index",
                    'as'   => "addworking.contract.contract_template_variable.index",
                ]);

                Route::get("{$base}/variable/create", [
                    'uses' => "ContractTemplateVariableController@create",
                    'as'   => "addworking.contract.contract_template_variable.create",
                ]);

                Route::post("{$base}/variable", [
                    'uses' => "ContractTemplateVariableController@store",
                    'as'   => "addworking.contract.contract_template_variable.store",
                ]);

                Route::get("{$base}/variable/{contract_template_variable}", [
                    'uses' => "ContractTemplateVariableController@show",
                    'as'   => "addworking.contract.contract_template_variable.show",
                ]);

                Route::get("{$base}/variable/{contract_template_variable}/edit", [
                    'uses' => "ContractTemplateVariableController@edit",
                    'as'   => "addworking.contract.contract_template_variable.edit",
                ]);

                Route::put("{$base}/variable/{contract_template_variable}", [
                    'uses' => "ContractTemplateVariableController@update",
                    'as'   => "addworking.contract.contract_template_variable.update",
                ]);

                Route::delete("{$base}/variable/{contract_template_variable}", [
                    'uses' => "ContractTemplateVariableController@destroy",
                    'as'   => "addworking.contract.contract_template_variable.destroy",
                ]);
            });
    }
}
