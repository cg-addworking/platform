@extends('foundation::layout.app.edit', ['action' => route('document_type_model.update', [$enterprise, $document_type, $document_type_model])])

@section('title', __('document_type_model::document_type_model.edit.title'))

@section('toolbar')
    @button(__('document_type_model::document_type_model.edit.return')."|href:".route('document_type_model.index', [$enterprise, $document_type])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('document_type_model::document_type_model._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('document_type_model::document_type_model._form')

    <fieldset>
        <div class="form-group" id="div-text">
            <label>{{ __('document_type_model::document_type_model._form.textarea') }}</label>
            <textarea class="form-control" name="document_type_model[content]" rows="25">
                {{$document_type_model->getContent()}}
            </textarea>
        </div>
    </fieldset>

    @button(__('document_type_model::document_type_model.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection

@push('scripts')
    @include('document_type_model::document_type_model._tinymce')
@endpush
