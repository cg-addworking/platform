@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_variable._table_row_empty.the_contract') }} {{ $contract_variable->contract->views->link }} {{ __('addworking.contract.contract_variable._table_row_empty.has_no_variables') }}

    @slot('create')
        @can('create', [get_class($contract_variable), $contract_variable->contract])
            @component('bootstrap::button', ['href' => $contract_variable->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_variable._table_row_empty.add_variable') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
