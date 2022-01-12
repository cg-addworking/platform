@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_party._table_row_empty.the_contract') }} {{ $contract_party->contract->views->link }} {{ __('addworking.contract.contract_party._table_row_empty.has_no_stakeholder') }}

    @slot('create')
        @can('create', [get_class($contract_party), $contract_party->contract])
            @component('bootstrap::button', ['href' => $contract_party->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_party._table_row_empty.add_stakeholder') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
