@extends('foundation::layout.app.index')

@section('title', __('billing.outbound.application.views.item.index_credit_line.lines_number')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @can('create', [$outboundInvoice, $enterprise])
        @button(__('billing.outbound.application.views.item.index_credit_line.create')."|href:".route('addworking.billing.outbound.credit_note.index_associate', [$enterprise, $outboundInvoice])."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
    @button(__('billing.outbound.application.views.item.index_credit_line.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::item._breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="20%">
    <col width="10%">
    <col width="25%">
    <col width="10%">
    <col width="5%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @include('outbound_invoice::item._table_head')
@endsection

@section('table.body')
    @foreach ($items as $outboundInvoiceItem)
        @include('outbound_invoice::item._table_row', compact('outboundInvoiceItem'))
    @endforeach
@endsection

