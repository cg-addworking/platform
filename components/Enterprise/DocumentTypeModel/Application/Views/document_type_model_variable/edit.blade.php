@extends('foundation::layout.app.edit', ['action' => route('document_type_model.variable.update', [$enterprise, $document_type, $document_type_model]), 'method' => 'PUT'])

@section('title', __('document_type_model::document_type_model_variable.edit.title'))

@section('toolbar')
    @button(__('document_type_model::document_type_model_variable.edit.return')."|href:".route('document_type_model.show', [$enterprise, $document_type, $document_type_model])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('document_type_model::document_type_model_variable._breadcrumb')
@endsection

@section('form')
    @include('document_type_model::document_type_model_variable._form')

    @button(__('document_type_model::document_type_model_variable.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection