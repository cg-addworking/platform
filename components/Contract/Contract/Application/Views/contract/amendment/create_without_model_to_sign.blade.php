@extends('foundation::layout.app.create', ['action' => route('contract.store_amendment_without_model_to_sign', $contract_parent), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.amendment.create_without_model_to_sign.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.amendment.create_without_model_to_sign.return')."|href:".route('contract.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "create_without_model_to_sign"])
@endsection

@section('form')
    @include('contract::contract.amendment._form_without_model_to_sign')
    @button(__('components.contract.contract.application.views.amendment.create_without_model_to_sign.submit')."|type:submit|color:success|shadow|icon:check")
@endsection