@component('foundation::layout.app._actions', ['model' => $contract_party])
    @can('assignSignatory', $contract_party)
        @action_item(__('addworking.contract.contract_party._actions.signatory')."|href:{$contract_party->routes->assign_signatory}")
    @endcan

    @can('dissociateSignatory', $contract_party)
        @action_item(__('addworking.contract.contract_party._actions.dissociate_signer')."|href:{$contract_party->routes->dissociate_signatory}")
    @endcan

    @can('viewAny', [App\Models\Addworking\Contract\ContractPartyDocumentType::class, $contract_party])
        @action_item(__('addworking.contract.contract_party._actions.required_document')."|href:{$contract_party->contractPartyDocumentTypes()->make()->routes->index}")
    @endcan
@endcomponent
