@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_template_variable.index.variables'))

@section('toolbar')
    @can('create', [get_class($contract_template_variable), $contract_template_variable->contractTemplate])
        @button(__('addworking.contract.contract_template_variable.index.add')."|href:{$contract_template_variable->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_template_variable->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_template_variable->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_template_variable)
        @can('view', $contract_template_variable)
            {{ $contract_template_variable->views->table_row }}
        @endcan
    @empty
        {{ $contract_template_variable->views->table_row_empty }}
    @endforelse
@endsection
