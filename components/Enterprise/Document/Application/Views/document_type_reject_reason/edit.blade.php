@extends('foundation::layout.app.edit', ['action' => route('support.document_type_reject_reason.update', [$enterprise, $document_type, $document_type_reject_reason])])

@section('title', __('document::document.document_type_reject_reason.edit.title', ["number" => $document_type_reject_reason->getNumber()]))

@section('toolbar')
    @button(__('document::document.document_type_reject_reason.edit.return')."|href:".route('support.document_type_reject_reason.index', [$enterprise, $document_type])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('document::document_type_reject_reason._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('document::document_type_reject_reason._form', ['page' => 'edit'])

    @button(__('document::document.document_type_reject_reason.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
