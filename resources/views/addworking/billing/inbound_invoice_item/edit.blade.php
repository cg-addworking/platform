@extends('foundation::layout.app.edit', ['action' => $inbound_invoice_item->routes->update])

@section('title', __('addworking.billing.inbound_invoice_item.edit.edit_invoice_line'))

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice_item.edit.return') ."|href:{$inbound_invoice_item->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.edit.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.edit.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.edit.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.edit.invoice_lines') ."|href:{$inbound_invoice_item->routes->index}")
    @breadcrumb_item("{$inbound_invoice_item->label}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.edit.modifier') ."|active")
@endsection

@section('form')
    {{ $inbound_invoice_item->views->form }}

    @button(__('addworking.billing.inbound_invoice_item.edit.register') ."|icon:save|type:submit")
@endsection
