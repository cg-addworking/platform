@extends('foundation::layout.app.index')

@section('title', "Factures Addworking")

@section('breadcrumb')
    @include('outbound_invoice::support._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('outbound_invoice::support._filter')
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="10%">
    <col width="25%">
    <col width="5%">
    <col width="5%">
    <col width="5%">
    <col width="5%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
    <col width="5%">
@endsection

@section('table.head')
    @include('outbound_invoice::support._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @forelse($items as $outboundInvoice)
        @include('outbound_invoice::support._table_row', compact('items'))
    @empty
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.support.index.text') }}</span>
        </div>
    @endforelse
@endsection
