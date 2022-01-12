@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract.index.contract'))

@section('toolbar')
    @can('create', [get_class($contract), $enterprise])
        @button(__('addworking.contract.contract.index.add')."|href:{$contract->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('form')
    <div class="row">
        <div class="col-md-3">
            @form_group([
                'text' => "Nom",
                'name' => "filter.name",
                'value' => request("filter.name"),
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => "Status",
                'type' => "select",
                'name' => "filter.status",
                'value' => request("filter.status"),
                'options' => Repository::contract()->getAvailableStatuses($contract, true),
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => "Échéance",
                'type' => "date",
                'name' => "filter.valid_until",
                'value' => request("filter.valid_until"),
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => "Partie prenante",
                'name' => "filter.contract_party_enterprise",
                'value' => request("filter.contract_party_enterprise")
            ])
        </div>
    </div>

    @button(__('addworking.contract.contract.index.filter')."|type:submit|icon:filter")

    @if(request()->has('filter'))
        <a href="{{ $contract->routes->index }}?reset" class="btn btn-outline btn-outline-secondary">
            @icon('times') {{ __('addworking.contract.contract.index.reset_filter') }}
        </a>
    @endif
@endsection

@section('table.head')
    {{ $contract->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract)
        @can('view', $contract)
            {{ $contract->views->table_row }}
        @endcan
    @empty
        {{ $contract->views->table_row_empty }}
    @endforelse
@endsection
