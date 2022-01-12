@inject('outboundInvoiceRepository', 'Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository')

@extends('foundation::layout.app.edit', ['action' => route('addworking.billing.outbound.update', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.edit.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @button(__('billing.outbound.application.views.edit.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('outbound_invoice::_form')

                @form_group([
                    'text'     => __('billing.outbound.application.views.edit.status'),
                    'type'     => "select",
                    'options'  => array_trans($outboundInvoiceRepository->getStatuses(),'billing.outbound.application.views._status.'),
                    'required' => true,
                    'name'     => 'outbound_invoice.status',
                    'value'    => $outboundInvoice->getStatus()
                ])
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.edit.edit_invoice')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection