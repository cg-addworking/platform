@inject('documentTypeRejectReasonRepository', 'Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository')
@extends('foundation::layout.app.index')

@section('title', __('document::document.document_type_reject_reason.index.title'))

@section('toolbar')
    @can('create', [get_class($documentTypeRejectReasonRepository->make([]))])
        @button(__('document::document.document_type_reject_reason.index.create')."|href:".route('support.document_type_reject_reason.create', [$enterprise, $document_type])."|icon:plus|color:success|outline|sm|mr:2")
    @endcan
 
    @button(__('document::document.document_type_reject_reason.index.return')."|href:".route('addworking.enterprise.document-type.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
     @include('document::document_type_reject_reason._breadcrumb')
@endsection

@section('table.head')
    @include('document::document_type_reject_reason._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $document_type_reject_reason)
        @include('document::document_type_reject_reason._table_row')
    @endforeach
@endsection