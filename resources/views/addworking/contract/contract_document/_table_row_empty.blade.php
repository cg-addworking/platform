@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_document._table_row_empty.the_contract') }} {{ $contract_document->contractParty->contract->views->link }} {{ __('addworking.contract.contract_document._table_row_empty.has_no_document') }}

    @slot('create')
        @can('create', [get_class($contract_document), $contract_document->contractParty])
            @component('bootstrap::button', ['href' => $contract_document->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_document._table_row_empty.add_document') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
