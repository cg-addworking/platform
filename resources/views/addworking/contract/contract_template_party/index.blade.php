@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_template_party.index.stakeholders'))

@section('toolbar')
    @can('create', [get_class($contract_template_party), $contract_template_party->contractTemplate])
        @button(__('addworking.contract.contract_template_party.index.add')."|href:{$contract_template_party->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_template_party->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_template_party->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_template_party)
        @can('view', $contract_template_party)
            {{ $contract_template_party->views->table_row }}
        @endcan
    @empty
        {{ $contract_template_party->views->table_row_empty }}
    @endforelse
@endsection
