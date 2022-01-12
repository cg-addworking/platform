@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_document.index.documents'))

@section('toolbar')
    @can('create', [get_class($contract_document), $contract_document->contract])
        @button(__('addworking.contract.contract_document.index.add')."|href:{$contract_document->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_document->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_document->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_document)
        @can('view', $contract_document)
            {{ $contract_document->views->table_row }}
        @endcan
    @empty
        {{ $contract_document->views->table_row_empty }}
    @endforelse
@endsection
