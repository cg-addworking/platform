@extends('foundation::layout.app.index')

@section('title', __('addworking.billing.inbound_invoice_item.index.lines_of') . $inbound_invoice->label)

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice_item.index.return') ."|href:{$inbound_invoice->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @if($items->count() > 0)
        @can('create', [inbound_invoice_item(), $inbound_invoice])
            @button(sprintf(__('addworking.billing.inbound_invoice_item.index.add_from_tracking_lines') ."|href:%s|icon:plus|color:outline-success|outline|sm|mr:2", route('addworking.billing.inbound_invoice_item.create_from_tracking_line', [$inbound_invoice->enterprise, $inbound_invoice])))
        @endcan
    @endif
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.index.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.index.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.index.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.index.invoice_lines') ."|active")
@endsection

@section('table.colgroup')
    <col width="40%">
    <col width="5%">
    <col width="5%">
    <col width="5%">
    <col width="10%">
    <col width="5%">
    <col width="10%">
    <col width="5%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.billing.inbound_invoice_item.index.label') ."|not_allowed")
    @th(__('addworking.billing.inbound_invoice_item.index.mission') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.customer_validation') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.provider_validation') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.unit_price') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.amount') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.amount_excluding') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.vat_rate') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice_item.index.action') ."|not_allowed|class:text-right")
@endsection

@section('form')
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">{{ __('addworking.billing.inbound_invoice_item.index.summary') }}</h4>
        <p class="mb-0">
            {{ __('addworking.billing.inbound_invoice_item.index.total_amount_excluding_taxes') }}<b>@money($inbound_invoice->items->getAmountBeforeTaxes())</b>
            <br>{{ __('addworking.billing.inbound_invoice_item.index.amount_of_taxes') }}<b>@money($inbound_invoice->items->getAmountOfTaxes())</b>
            <br>{{ __('addworking.billing.inbound_invoice_item.index.amount_all_taxes_included') }}<b>@money($inbound_invoice->items->getAmountAllTaxesIncluded())</b>
        </p>
    </div>
@endsection

@section('table.body')
    @forelse ($items as $inbound_invoice_item)
        {{ $inbound_invoice_item->views->table_row }}
    @empty
        {{ $inbound_invoice->views->table_row_empty }}
    @endforelse
@endsection
