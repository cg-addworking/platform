@component('foundation::layout.app._actions', ['model' => $contract])
    @can('download', $contract)
        @action_item(__('addworking.contract.contract._actions.download')."|href:{$contract->file->routes->download}")
    @endcan

    @can('view', $contract->contractTemplate)
        @action_item(__('addworking.contract.contract._actions.model')."|href:{$contract->contractTemplate->routes->show}")
    @endcan

    @can('createAddendum', $contract)
        @action_item(__('addworking.contract.contract._actions.create_addendum')."|href:{$contract->routes->createAddendum}")
    @endcan

    @can('viewAny', [get_class($contract_party = $contract->contractParties()->make()), $contract])
        @action_item(__('addworking.contract.contract._actions.stakeholders')."|href:".route('addworking.contract.contract_party.index', [$contract->enterprise, $contract]))
    @endcan
@endcomponent
