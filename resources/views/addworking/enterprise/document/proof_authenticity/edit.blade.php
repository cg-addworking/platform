@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.document.proof_authenticity.update', [$enterprise, $document]), 'enctype' => "multipart/form-data"])

@section('title', __('addworking.enterprise.document.proof_authenticity.edit.edit'))

@section('toolbar')
    @button(__('addworking.enterprise.document.proof_authenticity.edit.return') ."|href:".route('addworking.enterprise.document.show', [$enterprise, $document])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.proof_authenticity.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.proof_authenticity.edit.company')."|href:".route('enterprise.index'))
    @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
    @breadcrumb_item(__('addworking.enterprise.document.proof_authenticity.edit.document')."|href:".route('addworking.enterprise.document.index', $enterprise))
    @breadcrumb_item($document->documentType->display_name."|href:".route('addworking.enterprise.document.show', [$enterprise, $document]))
    @breadcrumb_item(__('addworking.enterprise.document.proof_authenticity.edit.edit')."|active")
@endsection

@section('form')
    @include("addworking.enterprise.document.proof_authenticity._form")

    <div class="text-right my-5">
        <button type="submit" class="btn btn-success" id="save_button">
            <i class="fas fa-check"></i>
            {{__('addworking.enterprise.document.proof_authenticity.edit.record')}}
        </button>
    </div>
@endsection
