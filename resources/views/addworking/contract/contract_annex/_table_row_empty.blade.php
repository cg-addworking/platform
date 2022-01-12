@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_annex._table_row_empty.the_contract') }} {{ $contract_annex->contract->views->link }} {{ __('addworking.contract.contract_annex._table_row_empty.does_not_have_annex') }}

    @slot('create')
        @can('create', [get_class($contract_annex), $contract_annex->contract])
            @component('bootstrap::button', ['href' => $contract_annex->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_annex._table_row_empty.add_document') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
