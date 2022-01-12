@inject('outboundInvoiceRepository', 'Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository')
@inject('deadlineRepository', 'Components\Billing\Outbound\Application\Repositories\DeadlineRepository')

@form_group([
    'text'     => __('billing.outbound.application.views._form.billing_period'),
    'type'     => "select",
    'options'  => $outboundInvoiceRepository->getPeriods(),
    'required' => true,
    'name'     => 'outbound_invoice.month',
    'value'    => optional($outboundInvoice)->getMonth()
])

@form_group([
    'text'     => __('billing.outbound.application.views._form.invoice_date'),
    'type'     => "date",
    'required' => true,
    'name'     => "outbound_invoice.invoiced_at",
    'value'    => optional($outboundInvoice)->getInvoicedAt()
])

@form_group([
    'text'     => __('billing.outbound.application.views._form.due_date'),
    'type'     => "date",
    'required' => false,
    'name'     => "outbound_invoice.due_at",
    'value'    => optional($outboundInvoice)->getDueAt()
])

@form_group([
    'text'     => __('billing.outbound.application.views._form.payment_deadline'),
    'type'     => "select",
    'options'  => $deadlineRepository->getDeadlines(),
    'required' => true,
    'name'     => 'outbound_invoice.deadline',
    'value'    => optional($outboundInvoice->getDeadline())->name
])
