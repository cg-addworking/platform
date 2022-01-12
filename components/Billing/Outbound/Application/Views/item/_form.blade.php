@inject('vatRateRepository', 'Components\Billing\Outbound\Application\Repositories\VatRateRepository')

@form_group([
    'text'         => __('billing.outbound.application.views.item._form.vat_rate'),
    'type'         => "select",
    'options'      => $vatRateRepository->getVatRates()->pluck('display_name', 'id'),
    'required'     => true,
    'name'         => "outbound_invoice_item.vat_rate_id",
    'value'        => optional($outboundInvoiceItem)->vat_rate
])

@form_group([
    'text'     => __('billing.outbound.application.views.item._form.label'),
    'type'     => "text",
    'required' => true,
    'name'     => "outbound_invoice_item.label",
    'value'    => optional($outboundInvoiceItem)->label
])

@form_group([
    'text'     => __('billing.outbound.application.views.item._form.quantity'),
    'type'     => "text",
    'required' => true,
    'name'     => "outbound_invoice_item.quantity",
    'value'    => optional($outboundInvoiceItem)->quantity
])

@form_group([
    'text'     => __('billing.outbound.application.views.item._form.unit_price'),
    'type'     => "text",
    'required' => true,
    'name'     => "outbound_invoice_item.unit_price",
    'value'    => optional($outboundInvoiceItem)->unit_price
])
