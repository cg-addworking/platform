@inject('subcontractingDeclarationRepository', 'Components\Contract\Contract\Application\Repositories\SubcontractingDeclarationRepository')

<fieldset class="offset-2 col-md-8">
    @if($percent = $subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract))
        <div class="alert alert-primary" role="alert">
            {{__('components.contract.contract.application.views.contract.capture_invoice._form.dc4_text', ['percent' => $percent->getPercentOfAggregation()])}}
        </div>
    @endif

    <div class="form-group">
        <label>
            {{__('components.contract.contract.application.views.contract.capture_invoice._form.vendor')}}
            <sup class=" text-danger font-italic">*</sup>
        </label>
        <select data-live-search="1" class="form-control shadow-sm selectpicker" name="capture_invoice[vendor]" disabled>
                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
        </select>
        <input type="hidden" name="capture_invoice[vendor_id]" value="{{$vendor->id}}" required>
    </div>

    <div class="form-group">
        <label>
            {{__('components.contract.contract.application.views.contract.capture_invoice._form.contract')}}
            <sup class=" text-danger font-italic">*</sup>
        </label>
        <select data-live-search="1" class="form-control shadow-sm selectpicker" name="capture_invoice[contract_id]" disabled>
            <option value="{{$contract->getId()}}">{{$contract->getName()}}</option>
        </select>
    </div>

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.contract_number'),
        'type'        => "text",
        'name'        => "capture_invoice.contract_number",
        'value'       => $contract->getNumber(),
        'disabled'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.invoiced_at'),
        'type'        => "date",
        'name'        => "capture_invoice.invoiced_at",
        'value'       => optional($capture_invoice)->getInvoicedAt() ?? '',
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.invoice_number'),
        'type'        => "text",
        'name'        => "capture_invoice.invoice_number",
        'value'       => optional($capture_invoice)->getInvoiceNumber() ?? '',
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.invoice_amount_before_taxes'),
        'type'        => "number",
        'step'        => 0.01,
        'name'        => "capture_invoice.invoice_amount_before_taxes",
        'value'       => optional($capture_invoice)->getInvoiceAmountBeforeTaxes() ?? 0,
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.invoice_amount_of_taxes'),
        'type'        => "number",
        'step'        => 0.01,
        'name'        => "capture_invoice.invoice_amount_of_taxes",
        'value'       => optional($capture_invoice)->getInvoiceAmountOfTaxes() ?? 0,
        'required'    => true,
    ])

    @if((count($contract->getCaptureInvoices()) == 0 && !$subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract)) || (isset($page) && $page == "edit"))
        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.dc4_date'),
                    'type'        => "date",
                    'name'        => "capture_invoice.dc4_date",
                    'value'       => optional($subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract))->getValidationDate() ?? ''
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.dc4_percent'),
                    'type'        => "number",
                    'step'        => 0.01,
                    'name'        => "capture_invoice.dc4_percent",
                    'value'       => optional($subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract))->getPercentOfAggregation() ?? ''
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.dc4_file'),
                'type'        => "file",
                'name'        => "capture_invoice.dc4_file",
                'accept'      => "application/pdf",
                'value'       => optional($subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract))->getFile() ?? ''
                ])
            </div>
        </div>
    @else
        <input type="hidden" name="capture_invoice[dc4_date]">
        <input type="hidden" name="capture_invoice[dc4_percent]">
        <input type="hidden" name="capture_invoice[dc4_file]">
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex">
                <label style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" data-toggle="tooltip" data-placement="top"
                       title="{{__('components.contract.contract.application.views.contract.capture_invoice._form.amount_guaranteed_holdback', ['number' => $guaranteed_holdback])}}">
                    {{__('components.contract.contract.application.views.contract.capture_invoice._form.amount_guaranteed_holdback', ['number' => $guaranteed_holdback])}}
                </label>
            </div>
            <input type="number" name="capture_invoice[amount_guaranteed_holdback]" step="0.01" class="form-control mb-2" value="{{optional($capture_invoice)->getAmountGuaranteedHoldback() ?? 0}}">
        </div>
        <div class="col-md-6">
            <label>{{__('components.contract.contract.application.views.contract.capture_invoice._form.deposit_guaranteed_holdback_number')}}</label>
            <input type="text" name="capture_invoice[deposit_guaranteed_holdback_number]" class="form-control mb-2" value="{{optional($capture_invoice)->getDepositGuaranteedHoldbackNumber() ?? ''}}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.amount_good_end'),
                'type'        => "number",
                'step'        => 0.01,
                'name'        => "capture_invoice.amount_good_end",
                'value'       => optional($capture_invoice)->getAmountGoodEnd() ?? 0
            ])
        </div>
        <div class="col-md-6">
            @form_group([
            'text'        => __('components.contract.contract.application.views.contract.capture_invoice._form.deposit_good_end_number'),
            'type'        => "text",
            'name'        => "capture_invoice.deposit_good_end_number",
            'value'       => optional($capture_invoice)->getDepositGoodEndNumber() ?? ''
            ])
        </div>
    </div>

    <div class="mt-3 text-right">
        <button type="submit" class="btn btn-success shadow mt-3">
            @icon('check') {{__('components.contract.contract.application.views.contract.capture_invoice._form.create')}}
        </button>
    </div>
</fieldset>
