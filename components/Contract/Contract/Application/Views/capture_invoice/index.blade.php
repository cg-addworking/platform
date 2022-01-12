@extends('foundation::layout.app.index')

@section('title', __('components.contract.contract.application.views.contract.capture_invoice.index.title', ['contract' => $contract->getName()]))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.capture_invoice.index.create')."|href:".route('contract.capture_invoice.create', $contract)."|icon:plus|color:success|outline|sm|mr:2")
    @button(__('components.contract.contract.application.views.contract.capture_invoice.index.return')."|href:".route('contract_accounting_monitoring.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::capture_invoice._breadcrumb')
@endsection

@section('table.head')
    @include('contract::capture_invoice._table_head')
@endsection

@section('table.body')
    @foreach ($items as $invoice)
        @include('contract::capture_invoice._table_row')
    @endforeach
@endsection
