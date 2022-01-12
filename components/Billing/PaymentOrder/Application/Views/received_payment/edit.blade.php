@extends('foundation::layout.app.edit', ['action' => route('addworking.billing.received_payment.update', [$enterprise, $received_payment])])

@section('title',  __('addworking.components.billing.outbound.received_payment.edit.title').$received_payment->getNumber())

@section('toolbar')
    @button(__('addworking.components.billing.outbound.received_payment.buttons.return')."|href:".route('addworking.billing.received_payment.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('payment_order::received_payment._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('payment_order::received_payment._form')
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('addworking.components.billing.outbound.received_payment.buttons.edit')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection