@extends('foundation::layout.app.create', ['action' => route('contract.party.store', $contract), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract_party.create.title', ['number' => $contract->getNumber()]))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract_party.create.return')."|href:".route('contract.create')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract_party._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <div class="container">
        <div class="align-items-center">
            @include('contract::contract_party._form')
            @button(__('components.contract.contract.application.views.contract_party.create.create')."|type:submit|color:success|shadow|icon:check")
        </div>
    </div>
@endsection
