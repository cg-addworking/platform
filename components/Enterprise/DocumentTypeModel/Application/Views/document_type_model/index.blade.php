@extends('foundation::layout.app.index')

@section('title', __('document_type_model::document_type_model.index.title', ['type' => $document_type->display_name]))

@section('toolbar')
    @button(__('document_type_model::document_type_model.index.return')."|href:".route('addworking.enterprise.document-type.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('document_type_model::document_type_model.index.create')."|href:".route('document_type_model.create', [$enterprise, $document_type])."|icon:plus|color:success|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('document_type_model::document_type_model._breadcrumb')
@endsection

@section('table.head')
    @include('document_type_model::document_type_model._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $document_type_model)
        @include('document_type_model::document_type_model._table_row')
    @endforeach
@endsection