@inject('enterpriseRepository', 'Components\Billing\Outbound\Application\Repositories\EnterpriseRepository')
@inject('feeRepository', 'Components\Billing\Outbound\Application\Repositories\FeeRepository')

@form_group([
    'text'     => "Type de commission",
    'type'     => "select",
    'options'  => $feeRepository->getTypes(),
    'required' => true,
    'name'     => 'fee.type',
    'value'    => optional($fee)->getType()
])

@form_group([
    'text'     => "Prestataire",
    'type'     => "select",
    'options'  => $enterpriseRepository->getActiveVendors($enterprise, $outboundInvoice->getMonth())->pluck('name', 'id'),
    'required' => false,
    'name'     => 'fee.vendor_id',
    'value'    => optional($fee)->getVendor(),
    'selectpicker' => true,
    'search'       => true
])

@form_group([
    'text'     => "Libellé",
    'type'     => "text",
    'required' => true,
    'name'     => "fee.label",
    'value'    => optional($fee)->getLabel()
])

@form_group([
    'text'     => "Montant",
    'type'     => "text",
    'required' => true,
    'name'     => "fee.amount_before_taxes",
    'value'    => optional($fee)->getAmountBeforeTaxes()
])