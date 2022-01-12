@component('layout.app._table_row_empty')
    {{ __('addworking.contract.contract_template_annex._table_row_empty.the_template') }} {{ $contract_template_annex->contractTemplate->views->link }} {{ __('addworking.contract.contract_template_annex._table_row_empty.does_not_have_annex') }}

    @slot('create')
        @can('create', [get_class($contract_template_annex), $contract_template_annex->enterprise])
            @component('bootstrap::button', ['href' => $contract_template_annex->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.contract.contract_template_annex._table_row_empty.add_document') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
