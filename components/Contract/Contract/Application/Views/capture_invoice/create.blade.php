@extends('foundation::layout.app.create', ['action' => route('contract.capture_invoice.store', $contract), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract.capture_invoice.create.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.capture_invoice.create.return')."|href:".route('contract_accounting_monitoring.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::capture_invoice._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('contract::capture_invoice._form')
@endsection
