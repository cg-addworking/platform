<?php

namespace Components\Contract\Contract\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ContractRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Contract\Contract\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapContractSupportRoutes();
        $this->mapContractRoutes();
        $this->mapContractAjaxRoutes();
        $this->mapContractPartRoutes();
        $this->mapContractPartyRoutes();
        $this->mapContractVariableRoute();
        $this->mapContractPartyDocumentRoutes();
        $this->mapContractMissionRoutes();
        $this->mapContractAccountingMonitoringRoutes();
        $this->mapContractCaptureInvoiceRoutes();
        $this->mapAnnexSupportRoutes();
        $this->mapAnnexRoutes();
    }

    private function mapContractSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "contract";

                Route::get("{$base}/create", [
                    'uses' => 'ContractController@createSupport', 'as' => 'contract.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractController@store', 'as' => 'contract.store'
                ]);

                Route::get("{$base}", [
                    'uses' => 'ContractController@indexSupport', 'as' => 'contract.index'
                ]);

                Route::get("{$base}/enterprise/{enterprise}", [
                    'uses' => 'ContractController@indexSupportForEnterprise', 'as' => 'contract.index.enterprise'
                ]);

                Route::get("{$base}/{contract}/update-from-yousign-data", [
                    'uses' => 'ContractController@updateContractFromYousignData', 'as' => 'contract.update.from_yousign'
                ]);
            });
    }

    private function mapContractRoutes()
    {
        Route::namespace($this->namespace)
            ->group(function () {
                Route::get("contract/callback-member-finished", [
                    'uses' => 'ContractController@callbackMemberFinished',
                    'as' => 'contract.callback_member_finished'
                ]);
                Route::get("contract/callback-procedure-refused", [
                    'uses' => 'ContractController@callbackProcedureRefused',
                    'as' => 'contract.callback_procedure_refused'
                ]);
                Route::get("contract/callback-procedure-finished", [
                    'uses' => 'ContractController@callbackProcedureFinished',
                    'as' => 'contract.callback_procedure_finished'
                ]);

                // @deprecated v1.6.0
                Route::get("contract/webhook", [
                    'uses' => 'ContractController@webhook', 'as' => 'contract.webhook'
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract";

                Route::get("{$base}/create", [
                    'uses' => 'ContractController@create', 'as' => 'contract.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractController@store', 'as' => 'contract.store'
                ]);

                Route::get("{$base}/export", [
                    'uses' => 'ContractController@export', 'as' => 'contract.export'
                ]);

                Route::get("{$base}/", [
                    'uses' => 'ContractController@index', 'as' => 'contract.index'
                ]);

                Route::get("{$base}/signature-successed", [
                    'uses' => 'ContractController@signatureSuccessed', 'as' => 'contract.signature_successed'
                ]);

                Route::get("{$base}/signature-refused", [
                    'uses' => 'ContractController@signatureRefused', 'as' => 'contract.signature_refused'
                ]);

                Route::get("{$base}/create-without-model", [
                    'uses' => 'ContractController@createContractWithoutModel',
                    'as' => 'contract.create_contract_without_model'
                ]);

                Route::post("{$base}/store-without-model", [
                    'uses' => 'ContractController@storeContractWithoutModel',
                    'as' => 'contract.store_contract_without_model'
                ]);

                Route::get("{$base}/create-without-model-to-sign", [
                    'uses' => 'ContractController@createContractWithoutModelToSign',
                    'as' => 'contract.create_contract_without_model_to_sign'
                ]);

                Route::post("{$base}/store-without-model-to-sign", [
                    'uses' => 'ContractController@storeContractWithoutModelToSign',
                    'as' => 'contract.store_contract_without_model_to_sign'
                ]);

                Route::get("{$base}/{contract_parent}/create-amendment", [
                    'uses' => 'AmendmentController@create', 'as' => 'contract.amendment.create'
                ]);

                Route::post("{$base}/{contract_parent}/store-amendment", [
                    'uses' => 'AmendmentController@store', 'as' => 'contract.amendment.store'
                ]);

                Route::get("{$base}/{contract_parent}/amendment/create_without_model_to_sign", [
                    'uses' => 'AmendmentController@createAmendmentWithoutModelToSign',
                    'as' => 'contract.create_amendment_without_model_to_sign'
                ]);

                Route::post("{$base}/{contract_parent}/amendment/store_without_model_to_sign", [
                    'uses' => 'AmendmentController@storeAmendmentWithoutModelToSign',
                    'as' => 'contract.store_amendment_without_model_to_sign'
                ]);

                Route::get("{$base}/{contract_parent}/amendment/create-without-model", [
                    'uses' => 'AmendmentController@createAmendmentWithoutModel',
                    'as' => 'contract.create_amendment_without_model'
                ]);

                Route::post("{$base}/{contract_parent}/amendment/store-without-model", [
                    'uses' => 'AmendmentController@storeAmendmentWithoutModel',
                    'as' => 'contract.store_amendment_without_model'
                ]);

                Route::get("{$base}/{contract}/edit", [
                    'uses' => 'ContractController@edit', 'as' => 'contract.edit'
                ]);

                Route::put("{$base}/{contract}/update", [
                    'uses' => 'ContractController@update', 'as' => 'contract.update'
                ]);

                Route::delete("{$base}/{contract}/delete", [
                    'uses' => 'ContractController@delete', 'as' => 'contract.delete'
                ]);

                Route::get("{$base}/{contract}/cancel", [
                    'uses' => 'ContractController@cancel', 'as' => 'contract.cancel'
                ]);

                Route::get("{$base}/{contract}/deactivate", [
                    'uses' => 'ContractController@deactivate', 'as' => 'contract.deactivate'
                ]);

                Route::get("{$base}/{contract}", [
                    'uses' => 'ContractController@show', 'as' => 'contract.show'
                ]);

                Route::get("{$base}/{contract}/send-contract", [
                    'uses' => 'ContractNotificationController@sendContract', 'as' => 'contract.send_contract'
                ]);

                Route::get("{$base}/{contract}/request-generation", [
                    'uses' => 'ContractNotificationController@requestValidation',
                    'as' => 'contract.request_validation'
                ]);

                Route::post("{$base}/{contract}/request-generation", [
                    'uses' => 'ContractNotificationController@postRequestValidation',
                    'as' => 'contract.send_request_validation'
                ]);

                Route::get("{$base}/{contract}/request-documents", [
                    'uses' => 'ContractNotificationController@requestDocuments',
                    'as' => 'contract.send_request_document_notification'
                ]);

                Route::get("{$base}/{contract}/request-signature", [
                    'uses' => 'ContractNotificationController@requestSignature', 'as' => 'contract.request_signature'
                ]);

                Route::get("{$base}/{contract}/upload-signed-contract", [
                    'uses' => 'ContractController@uploadSignedContract',
                    'as' => 'contract.upload_signed_contract'
                ]);

                Route::post("{$base}/{contract}/save-upload-signed-contract", [
                    'uses' => 'ContractController@saveUploadSignedContract',
                    'as' => 'contract.save_upload_signed_contract'
                ]);

                Route::get("{$base}/{contract}/sign/party/{party}", [
                    'uses' => 'ContractController@sign', 'as' => 'contract.sign'
                ]);

                Route::get("{$base}/{contract}/validate/party/{party}", [
                    'uses' => 'ContractController@validateContract', 'as' => 'contract.validate'
                ]);

                Route::get("{$base}/{contract}/send-to-sign", [
                    'uses' => 'ContractController@sendToSign', 'as' => 'contract.send_to_sign'
                ]);

                Route::get("{$base}/{contract}/send-to-manager", [
                    'uses' => 'ContractNotificationController@sendToManager',
                    'as' => 'contract.send_to_manager'
                ]);

                Route::post("{$base}/{contract}/request-contract-variable-value", [
                    'uses' => 'ContractNotificationController@requestContractVariableValue',
                    'as' => 'contract.request_contract_variable_value'
                ]);

                Route::get("{$base}/{contract}/call-back", [
                    'uses' => 'ContractController@callBackContract',
                    'as' => 'contract.call_back'
                ]);

                Route::get("{$base}/{contract}/download", [
                    'uses' => 'ContractController@download',
                    'as' => 'contract.download'
                ]);

                Route::get("{$base}/{contract}/archive", [
                    'uses' => 'ContractController@archive',
                    'as' => 'contract.archive'
                ]);

                Route::get("{$base}/{contract}/unarchive", [
                    'uses' => 'ContractController@unarchive',
                    'as' => 'contract.unarchive'
                ]);
                
                Route::get("{$base}/{contract}/download-documents", [
                    'uses' => 'ContractController@downloadDocuments',
                    'as' => 'contract.download_documents'
                ]);

                Route::get("{$base}/{contract}/download-proof-of-signature", [
                    'uses' => 'ContractController@downloadProofOfSignature',
                    'as' => 'contract.download_proof_of_signature'
                ]);
            });
    }

    private function mapContractAjaxRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract";
                Route::post("{$base}/get-signatories", [
                    'uses' => 'ContractAjaxController@getSignatories', 'as' => 'contract.get_signatories'
                ]);

                Route::post("{$base}/get-partners", [
                    'uses' => 'ContractAjaxController@getPartners', 'as' => 'contract.get_partners'
                ]);

                Route::post("{$base}/get-vendors", [
                    'uses' => 'ContractAjaxController@getVendors', 'as' => 'contract.get_vendors'
                ]);

                Route::post("{$base}/get-contract-models", [
                    'uses' => 'ContractAjaxController@getContractModels', 'as' => 'contract.get_contract_models'
                ]);

                Route::post("{$base}/get-amendment-owner-enterprises", [
                    'uses' => 'ContractAjaxController@getAmendmentOwnerEnterprise',
                    'as' => 'contract.get_amendment_owner_enterprises'
                ]);

                Route::post("{$base}/get-enterprises", [
                    'uses' => 'ContractAjaxController@getEnterprises',
                    'as' => 'contract.get_enterprises'
                ]);

                Route::post("{$base}/get-enterprise-missions", [
                    'uses' => 'ContractAjaxController@getEnterpriseMissions',
                    'as' => 'contract.get_enterprise_missions'
                ]);

                Route::post("{$base}/get-customer-vendors", [
                    'uses' => 'ContractAjaxController@getCustomerVendors', 'as' => 'contract.get_customer_vendors'
                ]);

                Route::post("{$base}/get-contract-owner-enterprises", [
                    'uses' => 'ContractAjaxController@getContractOwnerEnterprises',
                    'as' => 'contract.get_contract_owner_enterprises'
                ]);

                Route::post("{$base}/get-contract-parties", [
                    'uses' => 'ContractAjaxController@getContractParties',
                    'as' => 'contract.get_contract_parties'
                ]);

                Route::post("{$base}/get-contract-creator-users", [
                    'uses' => 'ContractAjaxController@getContractCreatorUsers',
                    'as' => 'contract.get_contract_creator_users'
                ]);

                Route::post("{$base}/get-list-contract-models", [
                    'uses' => 'ContractAjaxController@getListOfContractModels',
                    'as' => 'contract.get_list_contract_models'
                ]);

                Route::post("{$base}/get-workfields", [
                    'uses' => 'ContractAjaxController@getWorkfields',
                    'as' => 'contract.get_workfields'
                ]);
            });
    }

    private function mapContractPartRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract/{contract}/contract-part";

                Route::get("{$base}/create", [
                    'uses' => 'ContractPartController@create', 'as' => 'contract.part.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractPartController@store', 'as' => 'contract.part.store'
                ]);

                Route::get("{$base}/signed-contract-part-create", [
                    'uses' => 'ContractPartController@createSignedContractPart',
                    'as' => 'contract.part.create.signed.contract.part'
                ]);

                Route::post("{$base}/signed-contract-part-store", [
                    'uses' => 'ContractPartController@storeSignedContractPart',
                    'as' => 'contract.part.store.signed.contract.part'
                ]);

                Route::delete("{$base}/{contract_part}/delete", [
                    'uses' => 'ContractPartController@delete', 'as' => 'contract.part.delete'
                ]);

                Route::put("{$base}/{contract_part}/order", [
                    'uses' => 'ContractPartController@order', 'as' => 'contract.part.order'
                ]);

                Route::get("{$base}/regenerate", [
                    'uses' => 'ContractPartController@regenerate', 'as' => 'contract.part.regenerate'
                ]);

                Route::get("{$base}/ajax-get-available-annexes", [
                    'uses' => 'AnnexController@ajaxGetAvailableAnnexes',
                    'as' => 'contract.part.ajax_get_available_annexes'
                ]);
            });
    }

    private function mapContractPartyDocumentRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract/{contract}/contract-party/{contract_party}/document";

                Route::get("{$base}", [
                    'uses' => 'ContractPartyDocumentController@index', 'as' => 'contract.party.document.index'
                ]);

                Route::get("contract/{contract}/enterprise/{enterprise}/create-specific-document", [
                    'uses' => 'ContractPartyDocumentController@createSpecificDocument',
                    'as'   => 'contract.party.document.create_without_document_type',
                ]);

                Route::post("contract/{contract}/enterprise/{enterprise}/store-specific-document", [
                    'uses' => 'ContractPartyDocumentController@storeSpecificDocument',
                    'as'   => 'contract.party.document.store_without_document_type',
                ]);
            });
    }

    private function mapContractPartyRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract/{contract}/contract-party";

                Route::get("{$base}/create", [
                    'uses' => 'ContractPartyController@create', 'as' => 'contract.party.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractPartyController@store', 'as' => 'contract.party.store'
                ]);

                Route::get("{$base}/search-enterprise", [
                    'uses' => 'ContractPartyController@searchEnterprise',
                    'as' => 'contract.party.search_enterprise'
                ]);

                Route::post("{$base}/get-parties-of-contract", [
                    'uses' => 'ContractPartyController@getPartiesOfContract',
                    'as' => 'contract.party.get_parties_of_contract'
                ]);

                Route::get("{$base}/edit-validators", [
                    'uses' => 'ContractPartyController@editValidators', 'as' => 'contract.party.edit_validators'
                ]);

                Route::put("{$base}/update-validators", [
                    'uses' => 'ContractPartyController@updateValidators', 'as' => 'contract.party.update_validators'
                ]);
            });
    }

    private function mapContractVariableRoute()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract/{contract}/variable";

                Route::get("{$base}/", [
                    'uses' => 'ContractVariableController@index', 'as' => 'contract.variable.index'
                ]);

                Route::get("{$base}/define-value", [
                    'uses' => 'ContractVariableController@edit', 'as' => 'contract.variable.define_value'
                ]);

                Route::put("{$base}/update-value", [
                    'uses' => 'ContractVariableController@update', 'as' => 'contract.variable.update_value'
                ]);

                Route::get("{$base}/refresh", [
                    'uses' => 'ContractVariableController@refreshSystemVariables', 'as' => 'contract.variable.refresh'
                ]);
            });
    }

    private function mapContractMissionRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "contract-mission";

                Route::get("{$base}/create", [
                    'uses' => 'ContractMissionController@create', 'as' => 'contract_mission.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ContractMissionController@store', 'as' => 'contract_mission.store'
                ]);
            });
    }

    private function mapContractAccountingMonitoringRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "accounting-monitoring";

                Route::get("{$base}/index", [
                    'uses' => 'AccountingMonitoringController@index', 'as' => 'contract_accounting_monitoring.index'
                ]);
            });
    }

    private function mapContractCaptureInvoiceRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "capture-invoice/contract/{contract}";

                Route::get("{$base}/index", [
                    'uses' => 'CaptureInvoiceController@index', 'as' => 'contract.capture_invoice.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'CaptureInvoiceController@create', 'as' => 'contract.capture_invoice.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'CaptureInvoiceController@store', 'as' => 'contract.capture_invoice.store'
                ]);

                Route::delete("{$base}/{capture_invoice}/delete", [
                    'uses' => 'CaptureInvoiceController@delete', 'as' => 'contract.capture_invoice.delete'
                ]);

                Route::get("{$base}/{capture_invoice}/edit", [
                    'uses' => 'CaptureInvoiceController@edit', 'as' => 'contract.capture_invoice.edit'
                ]);

                Route::put("{$base}/{capture_invoice}/update", [
                    'uses' => 'CaptureInvoiceController@update', 'as' => 'contract.capture_invoice.update'
                ]);
            });
    }

    private function mapAnnexSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                $base = "annex";

                Route::get("{$base}", [
                    'uses' => 'AnnexController@indexSupport', 'as' => 'annex.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'AnnexController@create', 'as' => 'annex.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'AnnexController@store', 'as' => 'annex.store'
                ]);

                Route::get("{$base}/ajax-get-enterprise", [
                    'uses' => 'AnnexController@ajaxGetEnterprises', 'as' => 'annex.ajax_get_enterprise'
                ]);

                Route::delete("{$base}/{annex}/delete", [
                    'uses' => 'AnnexController@delete', 'as' => 'annex.delete'
                ]);

                Route::post("{$base}/get-enterprises-with-annex", [
                    'uses' => 'AnnexController@getEnterprisesWithAnnexAjax',
                    'as' => 'annex.get_enterprises_with_annex'
                ]);
            });
    }

    private function mapAnnexRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "annex";

                Route::get("{$base}/", [
                    'uses' => 'AnnexController@index', 'as' => 'annex.index'
                ]);

                Route::get("{$base}/{annex}/show", [
                    'uses' => 'AnnexController@show', 'as' => 'annex.show'
                ]);
            });
    }
}
