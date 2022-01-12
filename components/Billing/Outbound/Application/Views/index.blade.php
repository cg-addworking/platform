@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.index')

@section('title', __('billing.outbound.application.views.index.title')." {$enterprise->name}")

@section('toolbar')
    @if ($items->count() > 0)
        @can('create', get_class($outboundInvoiceRepository->make()))
            @button(__('billing.outbound.application.views.index.create_invoice')."|href:".route('addworking.billing.outbound.create', $enterprise)."|icon:plus|color:outline-success|outline|sm|mr:2")
        @endcan
    @endif
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('outbound_invoice::_filter')
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @include('outbound_invoice::_table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @forelse ($items as $outboundInvoice)
        @continue (! $outboundInvoice->getPublishStatus() && ! auth()->user()->isSupport())
        @include('outbound_invoice::_table_row', compact('items'))
    @empty
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.index.the_enterprise') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views.index.text') }}</span>
            @support
                <div class="mt-4">
                    @button(sprintf(__('billing.outbound.application.views.index.create_invoice')."|href:%s|icon:plus|color:outline-success|outline|sm|mr:2", route('addworking.billing.outbound.create', $enterprise)))
                </div>
            @endsupport
        </div>
    @endforelse
@endsection

