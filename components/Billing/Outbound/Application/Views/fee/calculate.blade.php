@inject('outbound', 'Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository')

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.fee.store_calculate', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.fee.calculate.title')."{$outboundInvoice->number}")

@section('toolbar')
    @button(__('billing.outbound.application.views.fee.calculate.return')."|href:".route('addworking.billing.outbound.fee.index', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::fee._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <span>{{ __('billing.outbound.application.views.fee.calculate.text_1') }} <b>{{ $outboundInvoice->number }}</b>.</span>
                </div>
                @form_group([
                    'text'     => __('billing.outbound.application.views.fee.calculate.text_2'),
                    'type'     => "select",
                    'options'  => $outbound->getOutboundInvoicesForPeriodAndDeadline($enterprise, $outboundInvoice->getMonth(), $outboundInvoice->getDeadline())->pluck('label', 'id'),
                    'required' => true,
                    'name'     => 'outbound_invoice_number',
                    'value'    => $outboundInvoice->getId()
                ])
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.fee.calculate.calculate_commissions')."|type:submit|color:success|shadow|icon:calculator")
    </div>
@endsection