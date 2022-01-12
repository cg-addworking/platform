@extends('foundation::layout.app.edit', ['action' => route('contract.update', $contract)])

@section('title', __('components.contract.contract.application.views.contract.edit.title', ["number" => $contract->getNumber()]))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract._actions.back')."|href:".route('contract.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract::contract._form', ['page' => 'edit'])
    @include('contract::contract_party._form_edit')

    @button(__('components.contract.contract.application.views.contract.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
