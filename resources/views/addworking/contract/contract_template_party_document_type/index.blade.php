@extends('foundation::layout.app.index')

@section('title', __('addworking.contract.contract_template_party_document_type.index.documents_to_provide'))

@section('toolbar')
    @can('create', [get_class($contract_template_party_document_type), $contract_template_party_document_type->contractTemplateParty])
        @button(__('addworking.contract.contract_template_party_document_type.index.add')."|href:{$contract_template_party_document_type->routes->create}|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_template_party_document_type->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_template_party_document_type->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_template_party_document_type)
        @can('view', $contract_template_party_document_type)
            {{ $contract_template_party_document_type->views->table_row }}
        @endcan
    @empty
        {{ $contract_template_party_document_type->views->table_row_empty }}
    @endforelse
@endsection
