@extends('foundation::layout.app.create', ['action' => route('document_type_model.store', [$enterprise, $document_type])])

@section('title', __('document_type_model::document_type_model.create.title'))

@section('toolbar')
    @button(__('document_type_model::document_type_model.create.return')."|href:".route('document_type_model.index', [$enterprise, $document_type])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('document_type_model::document_type_model._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('document_type_model::document_type_model._form')

    <fieldset>
        <div class="form-group" id="div-text">
            <label>{{ __('document_type_model::document_type_model._form.textarea') }}</label>
            <textarea class="form-control" name="document_type_model[content]" rows="25"></textarea>
        </div>
    </fieldset>

    @button(__('document_type_model::document_type_model.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection

@push('scripts')
    @include('document_type_model::document_type_model._tinymce')
@endpush