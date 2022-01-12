@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_party_document_type.index.document_required_for')." {$contract_party_document_type->contractParty}")

@section('toolbar')
    @can('create', [get_class($contract_party_document_type), $contract_party_document_type->contractParty])
        @button(__('addworking.contract.contract_party_document_type.index.add')."|href:{$contract_party_document_type->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_party_document_type->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse($items as $contract_party_document_type)
        @can('view', $contract_party_document_type)
            {{ $contract_party_document_type->views->table_row }}
        @endcan
    @empty
        {{ $contract_party_document_type->views->table_row_empty }}
    @endforelse
@endsection
