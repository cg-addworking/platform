@component('foundation::layout.app._actions', ['model' => $contract_template_party])
    @can('viewAny', [get_class($contract_template_party_document_type = $contract_template_party->contractTemplatePartyDocumentTypes()->make()), $contract_template_party])
        @action_item(__('addworking.contract.contract_template_party._actions.documents_to_provide')."|href:{$contract_template_party_document_type}"))
    @endcan
@endcomponent
