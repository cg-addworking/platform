@extends('foundation::layout.app.create', ['action' => route('addworking.billing.received_payment.store', $enterprise)])

@section('title', __('addworking.components.billing.outbound.received_payment.create.title').$enterprise->name)

@section('toolbar')
    @button(__('addworking.components.billing.outbound.received_payment.buttons.return')."|href:".route('addworking.billing.received_payment.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('payment_order::received_payment._breadcrumb', ['page' => "create"])
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
        @button(__('addworking.components.billing.outbound.received_payment.buttons.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection