@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_party_document_type._table_row_empty.the_stakeholder') }} {{ $contract_party_document_type->contractParty->views->link }} {{ __('addworking.contract.contract_party_document_type._table_row_empty.has_no_document') }}

    @slot('create')
        @can('create', [get_class($contract_party_document_type), $contract_party_document_type->contractParty])
            @component('bootstrap::button', ['href' => $contract_party_document_type->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_party_document_type._table_row_empty.add_required_document') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
