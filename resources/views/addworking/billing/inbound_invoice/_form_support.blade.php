<fieldset class="mt-3 pt-2">
    <legend class="text-primary h5">@icon('user-shield') {{ __('addworking.billing.inbound_invoice._form_support.admin') }}</legend>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'     => __('addworking.billing.inbound_invoice._form_support.status'),
                'type'     => "select",
                'name'     => "inbound_invoice.status",
                'value'    => $inbound_invoice->status,
                'options'  => ['to_validate' => __('addworking.billing.inbound_invoice._form_support.to_validate'), 'pending' => __('addworking.billing.inbound_invoice._form_support.pending'), 'validated' => __('addworking.billing.inbound_invoice._form_support.validated'), 'paid' => __('addworking.billing.inbound_invoice._form_support.paid')],
                'required' => true,
            ])
        </div>
        <div class="col-md-6">
            @form_group([
            'text'         => __('addworking.billing.inbound_invoice._form_support.outbound_invoice'),
            'type'         => "select",
            'name'         => "inbound_invoice.outbound_invoice_id",
            'value'        => $inbound_invoice->outboundInvoice->id,
            'options'      => $inbound_invoice->getAvailableOutboundInvoices()->pluck('number', 'id'),
            'selectpicker' => true,
            'search'       => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @form_group([
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.admin_amount",
                'value'       => $inbound_invoice->admin_amount,
                'text'        => __('addworking.billing.inbound_invoice._form_support.admin_amount'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.admin_amount_of_taxes",
                'value'       => $inbound_invoice->admin_amount_of_taxes,
                'text'        => __('addworking.billing.inbound_invoice._form_support.admin_amount_of_taxes'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.admin_amount_all_taxes_included",
                'value'       => $inbound_invoice->admin_amount_all_taxes_included,
                'text'        => __('addworking.billing.inbound_invoice._form_support.admin_amount_all_taxes_included'),
            ])
        </div>
    </div>
</fieldset>

@push('scripts')
    <script type="text/javascript">
        $(function () {
            let fields = {
                admin_amount: $(':input[name="inbound_invoice[admin_amount]"]'),
                admin_amount_of_taxes : $(':input[name="inbound_invoice[admin_amount_of_taxes]"]'),
                admin_amount_all_taxes_included : $(':input[name="inbound_invoice[admin_amount_all_taxes_included]"]'),
            };

            let update_admin_amount_all_taxes_included = function () {
                let num = parseFloat(fields.admin_amount.val() || "0") + parseFloat(fields.admin_amount_of_taxes.val() || "0");
                fields.admin_amount_all_taxes_included.val(Math.round((num + Number.EPSILON) * 100) / 100);
            };

            fields.admin_amount.bind('keyup mouseup change', update_admin_amount_all_taxes_included);
            fields.admin_amount_of_taxes.bind('keyup mouseup change', update_admin_amount_all_taxes_included);
        })
    </script>
@endpush