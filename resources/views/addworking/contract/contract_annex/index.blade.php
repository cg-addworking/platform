@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_annex.index.annexes'))

@section('toolbar')
    @can('create', [get_class($contract_annex), $contract_annex->contract])
        @button(__('addworking.contract.contract_annex.index.add')."|href:{$contract_annex->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_annex->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_annex->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_annex)
        @can('view', $contract_annex)
            {{ $contract_annex->views->table_row }}
        @endcan
    @empty
        {{ $contract_annex->views->table_row_empty }}
    @endforelse
@endsection
