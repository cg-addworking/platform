@extends('foundation::layout.app.index')

@section('title', __('billing.outbound.application.views.fee.index_credit_fees.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')

        @button(__('billing.outbound.application.views.fee.index_credit_fees.cancel_commissions')."|href:".route('addworking.billing.outbound.credit_note.index_associate_fees', [$enterprise, $outboundInvoice])."|icon:minus-square|color:outline-danger|outline|sm|mr:2")

    @button(__('billing.outbound.application.views.fee.index_credit_fees.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::fee._breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="10%">
    <col width="20%">
    <col width="10%">
    <col width="20%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
@endsection

@section('table.head')
    @include('outbound_invoice::fee._table_head_credit_fees')
@endsection

@section('table.body')
    @foreach ($items as $fee)
        @include('outbound_invoice::fee._table_row_credit_fees', compact('items'))
    @endforeach
@endsection