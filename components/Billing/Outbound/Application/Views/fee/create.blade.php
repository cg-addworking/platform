@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.fee.store', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.fee.create.title')."{$outboundInvoice->number}")

@section('toolbar')
    @button(__('billing.outbound.application.views.fee.create.return')."|href:".route('addworking.billing.outbound.fee.index', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::fee._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('outbound_invoice::fee._form')
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.fee.create.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection