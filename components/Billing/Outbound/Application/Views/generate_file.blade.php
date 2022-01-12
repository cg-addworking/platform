@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.generate_file.store', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.generate_file.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @button(__('billing.outbound.application.views.generate_file.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "generateFile"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="reverse_charge_vat" name="outbound_invoice[reverse_charge_vat]" value="1" @if($outboundInvoice->getReverseChargeVat()) checked="checked" @endif>
                                <label class="custom-control-label" for="reverse_charge_vat">{{ __('billing.outbound.application.views.generate_file.reverse_vat') }}</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="dailly_assignment" name="outbound_invoice[dailly_assignment]" value="1" @if($outboundInvoice->getDaillyAssignment()) checked="checked" @endif>
                                <label class="custom-control-label" for="dailly_assignment">{{ __('billing.outbound.application.views.generate_file.received_by_assignment_daily') }}</label>
                            </div>
                        </div>
                        <div>
                            @form_group([
                                'text'     => __('billing.outbound.application.views.generate_file.legal_notice'),
                                'type'     => "textarea",
                                'required' => false,
                                'name'     => 'outbound_invoice.legal_notice',
                                'value'    => optional($outboundInvoice)->getLegalNotice()
                            ])
                            @form_group([
                                'text'     => __('billing.outbound.application.views.generate_file.address'),
                                'type'     => "select",
                                'options'  => $outboundInvoice->getEnterprise()->addresses()->get()->pluck('one_line', 'id'),
                                'required' => true,
                                'name'     => 'outbound_invoice.address',
                                'value'    => $outboundInvoice->getEnterprise()->address->id,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.generate_file.generate_file')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection