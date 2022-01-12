@extends('foundation::layout.app.create', ['action' => route('contract.send_request_validation', $contract), 'method' => 'post', 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract.request_validation.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.create.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract.request_validation.general_information') }}</legend>
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract.request_validation.user'),
            'type'     => "select",
            'name'     => "user",
            'options'    => $users->pluck('name', 'id'),
            'required' => true,
        ])
    </fieldset>

    @button(__('components.contract.contract.application.views.contract.request_validation.send')."|type:submit|color:success|shadow|icon:check")
@endsection
