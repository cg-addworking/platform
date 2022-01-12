@component('foundation::layout.app._actions', ['model' => $contract_template])
    @can('viewAny', [get_class($contract = $contract_template->contracts()->make()->enterprise()->associate($contract_template->enterprise)), $contract_template->enterprise])
        @action_item(__('addworking.contract.contract_template._actions.contracts')."|href:{$contract->routes->index}?contract_template={$contract_template->id}")
    @endcan

    @can('viewAny', [get_class($contract_template_annex = $contract_template->contractTemplateAnnexes()->make()), $contract_template])
        @action_item(__('addworking.contract.contract_template._actions.annexes')."|href:{$contract_template_annex->routes->index}")
    @endcan

    @can('viewAny', [get_class($contract_template_party = $contract_template->contractTemplateParties()->make()), $contract_template])
        @action_item(__('addworking.contract.contract_template._actions.stakeholders')."|href:{$contract_template_party->routes->index}")
    @endcan

    @can('viewAny', [get_class($contract_template_variable = $contract_template->contractTemplateVariables()->make()), $contract_template])
        @action_item(__('addworking.contract.contract_template._actions.variables')."|href:{$contract_template_variable->routes->index}")
    @endcan
@endcomponent
