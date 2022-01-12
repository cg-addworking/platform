<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.billing.inbound_invoice_item._form.general_information') }}</legend>
    <div class="row">
        <div class="col-6">
            @form_group([
                'text'     =>  __('addworking.billing.inbound_invoice_item._form.label'),
                'name'     => "inbound_invoice_item.label",
                'value'    => optional($inbound_invoice_item)->label,
                'required' => true,
            ])
        </div>
        <div class="col-2">
            @form_group([
                'text'        =>  __('addworking.billing.inbound_invoice_item._form.amount'),
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice_item.quantity",
                'value'       => optional($inbound_invoice_item)->quantity,
                'required'    => true,
            ])
        </div>
        <div class="col-2">
            @form_group([
                'text'        =>  __('addworking.billing.inbound_invoice_item._form.unit_price'),
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice_item.unit_price",
                'value'       => optional($inbound_invoice_item)->unit_price,
                'required'    => true,
            ])
        </div>
        <div class="col-2">
            @form_group([
                'text' =>  __('addworking.billing.inbound_invoice_item._form.vat_rate'),
                'type' => "select",
                'name' => "inbound_invoice_item.vat_rate_id",
                'value'   => optional($inbound_invoice_item->vatRate)->id,
                'options' => vat_rate([])->get()->sortByDesc('value')->pluck('display_name', 'id'),
                'required' => true,
            ])
        </div>
    </div>
</fieldset>
