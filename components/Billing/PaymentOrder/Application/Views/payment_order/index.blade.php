@inject('paymentOrderRepository', 'Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository')

@extends('foundation::layout.app.index')

@section('title', __('addworking.components.billing.outbound.payment_order.index.title'))

@section('toolbar')
    @button(__('addworking.components.billing.outbound.payment_order.index.button_return')."|href:#|icon:arrow-left|color:outline-secondary|outline|sm|mr:2")
    @can('create', get_class($paymentOrderRepository->make()))
        @button(__('addworking.components.billing.outbound.payment_order.index.button_create')."|href:". route('addworking.billing.payment_order.create', $enterprise)."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="25%">
    <col width="25%">
    <col width="25%">
    <col width="5%">
@endsection

@section('table.head')
    @include('payment_order::payment_order._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $payment_order)
        @include('payment_order::payment_order._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('addworking.components.billing.outbound.payment_order.index.table_row_empty') }}</span>
            @can('create', get_class($paymentOrderRepository->make()))
                <div class="mt-4">
                    @button(__('addworking.components.billing.outbound.payment_order.index.button_create')."|href:".route('addworking.billing.payment_order.create', $enterprise)."|icon:plus|color:outline-success|outline|sm|mr:2")
                </div>
            @endcan
        </div>
    @endforelse
@endsection
