@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_variable.index.variables'))

@section('toolbar')
    @can('create', [get_class($contract_variable), $contract_variable->contract])
        @button(__('addworking.contract.contract_variable.index.add')."|href:{$contract_variable->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_variable->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_variable->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_variable)
        @can('view', $contract_template_variable)
            {{ $contract_variable->views->table_row }}
        @endcan
    @empty
        {{ $contract_variable->views->table_row_empty }}
    @endforelse
@endsection
