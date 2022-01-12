@extends('foundation::layout.app.create', ['action' => route('enterprise.document.model.store_required_document', [$enterprise, $document]), 'enctype' => "multipart/form-data"])

@section('title', __('document::document_model.add_required_document.title'))

@section('toolbar')
    @button(__('document::document_model.add_required_document.return')."|href:".route('addworking.enterprise.document.show', [$enterprise, $document])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('document::document_model._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('document::document_model._breadcrumb.enterprises')."|href:".route('enterprise.index'))
    @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
    @breadcrumb_item(__('document::document_model._breadcrumb.documents')."|href:".route('addworking.enterprise.document.index', $enterprise))
    @breadcrumb_item($document->getDocumentType()->display_name."|href:".route('addworking.enterprise.document.index', $enterprise))
    @breadcrumb_item(__('document::document_model._breadcrumb.show')."|href:".route('addworking.enterprise.document.show', [$enterprise, $document]))
    @breadcrumb_item(__('document::document_model._breadcrumb.add_part')."|active")
@endsection

@section('form')

    <div class="form-group mb-3">
        @form_group([
        'type'        => "file",
        'name'        => "file",
        'required'    => true,
        'text'        => __('document::document_model.add_required_document.add_file'),
        ])
    </div>

    @button(__('document::document_model.add_required_document.create')."|type:submit|color:success|shadow|icon:check")
@endsection