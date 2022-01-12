@extends('foundation::layout.app.edit', ['action' => route('support.contract.model.variable.update', [$contract_model]), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model_variable.edit.title', ["number" => $contract_model->getNumber()]))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_variable.edit.return')."|href:".route('support.contract.model.variable.index', $contract_model)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_variable._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract_model::contract_model_variable._form')

    @button(__('components.contract.model.application.views.contract_model_variable.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
