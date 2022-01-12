@extends('foundation::layout.app.create', ['action' => route('support.contract.model.store'), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model.create.title'))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model.create.return')."|href:".route('support.contract.model.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('contract_model::contract_model._form')

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('handshake') {{ __('components.contract.model.application.views.contract_model.create.parties') }}</legend>
        @form_group([
            'text'        => __('components.contract.model.application.views.contract_model.create.party', ['number' => 1]),
            'type'        => "text",
            'name'        => "contract_model.parties.",
            'required'    => true,
        ])
        @form_group([
            'text'        => __('components.contract.model.application.views.contract_model.create.party', ['number' => 2]),
            'type'        => "text",
            'name'        => "contract_model.parties.",
            'required'    => true,
        ])
    </fieldset>
    @button(__('components.contract.model.application.views.contract_model.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
