@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_template._table_row_empty.the_enterprise') }} {{ $contract_template->enterprise->views->link }} {{ __('addworking.contract.contract_template._table_row_empty.has_no_contract_template') }}

    @slot('create')
        @can('create', [get_class($contract_template), $contract_template->enterprise])
            @component('bootstrap::button', ['href' => $contract_template->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_template._table_row_empty.create_contract_template') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
