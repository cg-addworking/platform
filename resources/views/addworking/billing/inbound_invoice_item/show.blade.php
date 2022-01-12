@extends('foundation::layout.app.show')

@section('title', $inbound_invoice_item->label)

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice_item.show.return') ."|href:{$inbound_invoice_item->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $inbound_invoice_item->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.show.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.show.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.show.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.show.invoice_lines') ."|href:{$inbound_invoice_item->routes->index}")
    @breadcrumb_item("{$inbound_invoice_item->label}|active")
@endsection

@section('content')
    {{ $inbound_invoice_item->views->html }}
@endsection
