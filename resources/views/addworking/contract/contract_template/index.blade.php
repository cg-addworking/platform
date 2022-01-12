@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_template.index.contract_templates'))

@section('toolbar')
    @can('create', [get_class($contract_template), $contract_template->enterprise])
        @button(__('addworking.contract.contract_template.index.add')."|href:{$contract_template->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_template->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_template->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_template)
        @can('view', $contract_template)
            {{ $contract_template->views->table_row }}
        @endcan
    @empty
        {{ $contract_template->views->table_row_empty }}
    @endforelse
@endsection
