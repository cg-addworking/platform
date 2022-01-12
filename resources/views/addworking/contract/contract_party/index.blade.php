@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_party.index.stakeholders'))

@section('toolbar')
    @can('create', [get_class($contract_party), $contract_party->contract])
        @button(__('addworking.contract.contract_party.index.add')."|href:{$contract_party->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_party->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_party->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse($items as $contract_party)
        @can('view', $contract_party)
            {{ $contract_party->views->table_row }}
        @endcan
    @empty
        {{ $contract_party->views->table_row_empty }}
    @endforelse
@endsection
