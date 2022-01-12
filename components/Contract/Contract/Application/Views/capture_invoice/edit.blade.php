@extends('foundation::layout.app.edit', ['action' => route('contract.capture_invoice.update', [$contract, $capture_invoice]),  'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract.capture_invoice.edit.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.capture_invoice.edit.return')."|href:".route('contract_accounting_monitoring.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::capture_invoice._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract::capture_invoice._form', ['page' => "edit"])
@endsection
