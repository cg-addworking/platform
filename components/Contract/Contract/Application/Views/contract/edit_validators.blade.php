@extends('foundation::layout.app.edit', ['action' => route('contract.party.update_validators', $contract)])

@section('title', __('components.contract.contract.application.views.contract.edit_validators.title', ["number" => $contract->getNumber()]))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract._actions.back')."|href:".route('contract.index', $contract->getEnterprise())."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract::contract_party._form_validators')

    @button(__('components.contract.contract.application.views.contract.edit_validators.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
