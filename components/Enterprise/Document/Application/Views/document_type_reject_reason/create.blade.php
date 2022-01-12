@extends('foundation::layout.app.create', ['action' => route('support.document_type_reject_reason.store', [$enterprise, $document_type])])

@section('title',__('document::document.document_type_reject_reason.create.title'))

@section('toolbar')
    @button(__('document::document.document_type_reject_reason.create.return')."|href:".route('support.document_type_reject_reason.index', [$enterprise, $document_type])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('document::document_type_reject_reason._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('document::document_type_reject_reason._form', ['page' => 'create'])

    @button(__('document::document.document_type_reject_reason.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
