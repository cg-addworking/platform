@extends('foundation::layout.app.show')

@section('title', __('addworking.components.billing.outbound.payment_order.show.title').$payment_order->getNumber())

@section('toolbar')
    @button(__('addworking.components.billing.outbound.payment_order.show.button_return')."|href:{$payment_order->routes->index}|icon:arrow-left|color:outline-secondary|outline|sm|mr:2")
    @can('generate', $payment_order)
        @button(__('addworking.components.billing.outbound.payment_order.show.generate')."|href:{$payment_order->routes->generate}|icon:file-alt|color:outline-success|outline|sm|mr:2")
    @endcan
    @can('execute', $payment_order)
        <a class="btn btn-sm btn-outline-warning mr-2" href="{{ $payment_order->routes->execute }}" onclick="confirm('Confirmer ?')">
            @icon('exchange-alt') <span>{{ __('addworking.components.billing.outbound.payment_order.show.execute') }}</span>
        </a>
    @endcan
    @include('payment_order::payment_order._actions')
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('payment_order::payment_order._html')
@endsection
