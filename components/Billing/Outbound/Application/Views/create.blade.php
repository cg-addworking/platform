@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.store', $enterprise)])

@section('title', __('billing.outbound.application.views.create.create_invoice_for')." {$enterprise->name}")

@section('toolbar')
    @button(__('billing.outbound.application.views.create.return')."|href:".route('addworking.billing.outbound.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('outbound_invoice::_form')
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.create.create_invoice')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection