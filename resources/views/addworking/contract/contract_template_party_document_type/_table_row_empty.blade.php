@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_template_party_document_type._table_row_empty.the_stakeholder') }} {{ $contract_template_party_document_type->contractTemplateParty->views->link }} {{ __('addworking.contract.contract_template_party_document_type._table_row_empty.does_not_require_document') }}

    @slot('create')
        @can('create', [get_class($contract_template_party), $contract_template_party->enterprise])
            @component('bootstrap::button', ['href' => $contract_template_party->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_template_party_document_type._table_row_empty.add_required_document') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
