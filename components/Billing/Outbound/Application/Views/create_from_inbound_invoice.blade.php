@inject('outboundInvoiceRepository', 'Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository')
@inject('deadlineRepository', 'Components\Billing\Outbound\Application\Repositories\DeadlineRepository')

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.store.inbound_invoice', [$enterprise, $inbound_invoice])])

@section('title', __('billing.outbound.application.views.create.create_invoice_for')." {$enterprise->name}")

@section('toolbar')
    @button(__('billing.outbound.application.views.create.return')."|href:".route('addworking.billing.inbound_invoice.show', [$inbound_invoice->enterprise, $inbound_invoice])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views._form.billing_period'),
                                    'type'     => "select",
                                    'options'  => $outboundInvoiceRepository->getPeriods(),
                                    'required' => true,
                                    'name'     => 'outbound_invoice.month',
                                    'value'    => $inbound_invoice->month
                                ])
                            </div>
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views._form.invoice_date'),
                                    'type'     => "date",
                                    'required' => true,
                                    'name'     => "outbound_invoice.invoiced_at",
                                    'value'    => Carbon\Carbon::createFromFormat('m/Y', $inbound_invoice->month)->endOfMonth()
                                ])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views._form.payment_deadline'),
                                    'type'     => "select",
                                    'options'  => $deadlineRepository->getDeadlines(),
                                    'required' => true,
                                    'name'     => 'outbound_invoice.deadline',
                                    'value'    => $inbound_invoice->deadline()->first()->name
                                ])

                            </div>
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views._form.due_date'),
                                    'type'     => "date",
                                    'required' => false,
                                    'name'     => "outbound_invoice.due_at",
                                ])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views.generate_file.address'),
                                    'type'     => "select",
                                    'options'  => $inbound_invoice->customer->addresses()->latest()->get()->pluck('one_line', 'id'),
                                    'required' => true,
                                    'name'     => 'outbound_invoice.address',
                                ])
                            </div>
                            <div class="col-6">
                                @form_group([
                                    'text'     => __('billing.outbound.application.views._form.include_fees'),
                                    'type'     => "select",
                                    'options'  => ['0' => __('billing.outbound.application.views._form.no'), '1' => __('billing.outbound.application.views._form.yes')],
                                    'required' => true,
                                    'name'     => 'outbound_invoice.include_fees',
                                ])
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="reverse_charge_vat" name="outbound_invoice[reverse_charge_vat]" value="1" @if($inbound_invoice->items->getAmountOfTaxes() == 0) checked @endif>
                                <label class="custom-control-label" for="reverse_charge_vat">{{ __('billing.outbound.application.views.generate_file.reverse_vat') }}</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="dailly_assignment" name="outbound_invoice[dailly_assignment]" value="1">
                                <label class="custom-control-label" for="dailly_assignment">{{ __('billing.outbound.application.views.generate_file.received_by_assignment_daily') }}</label>
                            </div>
                        </div>
                        <div>
                            @form_group([
                                'text'     => __('billing.outbound.application.views.generate_file.legal_notice'),
                                'type'     => "textarea",
                                'required' => false,
                                'name'     => 'outbound_invoice.legal_notice',
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button(__('billing.outbound.application.views.create.create_invoice')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection