@extends('foundation::layout.app.index')

@section('title', __('billing.outbound.application.views.item.index.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @if(count($items) > 0)
        @can('create', [$outboundInvoice, $enterprise])
            @button(__('billing.outbound.application.views.item.index.create')."|href:".route('addworking.billing.outbound.item.create', [$enterprise, $outboundInvoice])."|icon:plus|color:outline-success|outline|sm|mr:2")
        @endcan
    @endif
    @button(__('billing.outbound.application.views.item.index.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
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

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $outboundInvoiceItem)
        @include('outbound_invoice::item._table_row', compact('outboundInvoiceItem'))
    @empty
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.item.index.text_1') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views.item.index.text_2') }} <br> {{ __('billing.outbound.application.views.item.index.text_3') }} {{ $outboundInvoice->getMonth() }} {{ __('billing.outbound.application.views.item.index.text_4') }} {{ $outboundInvoice->getDeadline()->display_name }}.</span>
            @can('create', [\Components\Billing\Outbound\Application\Models\OutboundInvoiceItem::class, $enterprise, $outboundInvoice])
                <div class="mt-4">
                    @button(sprintf(__('billing.outbound.application.views.item.index.create_new')."|href:%s|icon:plus|color:outline-success|outline|sm|mr:2", route('addworking.billing.outbound.item.create', [$enterprise, $outboundInvoice])))
                </div>
            @endcan
        </div>
    @endforelse
@endsection

