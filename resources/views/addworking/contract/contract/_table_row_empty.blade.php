@component('layout.app._table_row_empty')
    @if($contract->parent->exists)
        {{ __('addworking.contract.contract._table_row_empty.the_contract') }} {{ $contract->parent->views->link }} {{ __('addworking.contract.contract._table_row_empty.has_no_addendum') }}
    @else
       {{ __('addworking.contract.contract._table_row_empty.the_company') }} {{ $contract->enterprise->views->link }} {{ __('addworking.contract.contract._table_row_empty.has_no_contract') }}
    @endif

    @if(request()->has('filter'))
        {{ __('addworking.contract.contract._table_row_empty.for_those_filters') }}
    @endif

    @slot('create')
        @if ($contract->parent->exists)
            @can('createAddendum', $contract)
                @component('bootstrap::button', ['href' => $contract->parent->routes->create_addendum, 'icon' => "plus", 'color' => "success"])
                    {{ __('addworking.contract.contract._table_row_empty.create_addendum') }}
                @endcomponent
            @endcan
        @else
            @can('create', [get_class($contract), $contract->enterprise])
                @component('bootstrap::button', ['href' => $contract->routes->create, 'icon' => "plus", 'color' => "success"])
                    {{ __('addworking.contract.contract._table_row_empty.create_contract') }}
                @endcomponent
            @endcan
        @endif
    @endslot
@endcomponent
