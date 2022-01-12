@component('foundation::layout.app._actions', ['model' => $contract_party_document_type])
    @can('attachExistingDocument', $contract_party_document_type)
        @action_item(__('addworking.contract.contract_party_document_type._actions.associate_existing_document')."|href:{$contract_party_document_type->routes->attach_existing_document}")
    @endcan

    @can('attachNewDocument', $contract_party_document_type)
        @action_item(__('addworking.contract.contract_party_document_type._actions.associate_new_document')."|href:{$contract_party_document_type->routes->attach_new_document}")
    @endcan

    @can('detachDocument', $contract_party_document_type)
        @action_item(__('addworking.contract.contract_party_document_type._actions.detach_document')."|href:{$contract_party_document_type->routes->detach_document}")
    @endcan
@endcomponent
