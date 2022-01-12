@extends('foundation::layout.app.create', ['action' => $inbound_invoice_item->routes->store])

@section('title', __('addworking.billing.inbound_invoice_item.create.create_invoice_line'))

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice_item.create.return') ."|href:{$inbound_invoice_item->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create.invoice_lines') ."|href:{$inbound_invoice_item->routes->index}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create.create') ."|active")
@endsection

@section('form')
    {{ $inbound_invoice_item->views->form }}

    @button(__('addworking.billing.inbound_invoice_item.create.create') ."|icon:save|type:submit")
@endsection
