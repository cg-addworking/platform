@extends('foundation::layout.app.create', ['action' => route('contract.part.store', $contract), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract_part.create.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract_part.create.return')."|href:".route('contract.show', $contract)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract_part._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('contract::contract_part._form')

    @button(__('components.contract.contract.application.views.contract_part.create.submit')."|type:submit|color:success|shadow|icon:check")
@endsection