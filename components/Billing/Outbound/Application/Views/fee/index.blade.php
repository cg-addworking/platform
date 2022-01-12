@extends('foundation::layout.app.index')

@section('title', __('billing.outbound.application.views.fee.index.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @button(__('billing.outbound.application.views.fee.index.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('create', [\Components\Billing\Outbound\Application\Models\Fee::class, $enterprise, $outboundInvoice])
        @button(__('billing.outbound.application.views.fee.index.calculate_commissions')."|href:".route('addworking.billing.outbound.fee.create_calculate', [$enterprise, $outboundInvoice])."|icon:calculator|color:outline-primary|outline|sm|mr:2")
    @endcan
    @can('create', [\Components\Billing\Outbound\Application\Models\Fee::class, $enterprise, $outboundInvoice])
        @button(__('billing.outbound.application.views.fee.index.create')."|href:".route('addworking.billing.outbound.fee.create', [$enterprise, $outboundInvoice])."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
    @if (count($items) > 0)
        @can('export', fee())
            @button(__('billing.outbound.application.views.fee.index.export')."|href:".route('addworking.billing.outbound.fee.export', [$enterprise, $outboundInvoice])."|icon:plus|color:outline-primary|outline|sm|mr:2")
        @endcan
    @endif
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
    @include('outbound_invoice::fee._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $fee)
        @include('outbound_invoice::fee._table_row', compact('items'))
    @empty
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.fee.index.text_1') }} <b>{{ $outboundInvoice->number }}</b> {{ __('billing.outbound.application.views.fee.index.text_2') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views.fee.index.text_3') }}</span>
            @can('create', [\Components\Billing\Outbound\Application\Models\Fee::class, $enterprise, $outboundInvoice])
                <div class="mt-4">
                    @button(sprintf(__('billing.outbound.application.views.fee.index.calculate_commissions')."|href:%s|icon:calculator|color:outline-success|outline|sm|mr:2", route('addworking.billing.outbound.fee.create_calculate', [$enterprise, $outboundInvoice])))
                </div>
            @endcan
        </div>
    @endforelse
@endsection