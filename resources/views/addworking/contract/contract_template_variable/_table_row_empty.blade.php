@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_template_variable._table_row_empty.the_template') }} {{ $contract_template_variable->contractTemplate->views->link }} {{ __('addworking.contract.contract_template_variable._table_row_empty.has_no_variables') }}

    @slot('create')
        @can('create', [get_class($contract_template_variable), $contract_template_variable->enterprise])
            @component('bootstrap::button', ['href' => $contract_template_variable->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_template_variable._table_row_empty.add_variable') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
