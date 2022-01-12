@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_template_party._table_row_empty.the_template') }} {{ $contract_template_party->contractTemplate->views->link }} {{ __('addworking.contract.contract_template_party._table_row_empty.has_no_stakeholder') }}

    @slot('create')
        @can('create', [get_class($contract_template_party), $contract_template_party->enterprise])
            @component('bootstrap::button', ['href' => $contract_template_party->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_template_party._table_row_empty.add_stakeholder') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
