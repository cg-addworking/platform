<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('enterprise.invoiceParameter.application.views._form.general_information') }}</legend>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @form_group([
                                'text'        => __('enterprise.invoiceParameter.application.views._form.starts_at'),
                                'type'        => "date",
                                'name'        => "starts_at",
                                'required'    => true,
                                'value'       => optional($invoice_parameter)->getStartsAt(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'        => __('enterprise.invoiceParameter.application.views._form.ends_at'),
                                'type'        => "date",
                                'name'        => "ends_at",
                                'value'       => optional($invoice_parameter)->getEndsAt(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'     => __('enterprise.invoiceParameter.application.views._form.default_iban'),
                                'type'     => "select",
                                'options'  => $addworking_ibans,
                                'required' => true,
                                'name'     => 'iban_id',
                                'value'    => optional(optional($invoice_parameter)->getIban())->id,
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'     => __('enterprise.invoiceParameter.application.views._form.invoicing_from_inbound_invoice'),
                                'type'     => "select",
                                'options'  => ['0' => __('enterprise.invoiceParameter.application.views._form.no'), '1' => __('enterprise.invoiceParameter.application.views._form.yes')],
                                'required' => true,
                                'name'     => 'invoicing_from_inbound_invoice',
                                'value'    => optional($invoice_parameter)->getInvoicingFromInboundInvoice(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'     => __('enterprise.invoiceParameter.application.views._form.vendor_creating_inbound_invoice_items'),
                                'type'     => "select",
                                'options'  => ['0' => __('enterprise.invoiceParameter.application.views._form.no'), '1' => __('enterprise.invoiceParameter.application.views._form.yes')],
                                'required' => true,
                                'name'     => 'vendor_creating_inbound_invoice_items',
                                'value'    => optional($invoice_parameter)->getVendorCreatingInboundInvoiceItems(),
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "subscription_amount",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.subscription_amount'),
                                'value'       => optional($invoice_parameter)->getSubscription(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "fixed_fees_by_vendor_amount",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.fixed_fees_by_vendor_amount'),
                                'value'       => optional($invoice_parameter)->getFixedFeesByVendor(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "default_management_fees_by_vendor",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.default_management_fees_by_vendor'),
                                'value'       => optional($invoice_parameter)->getDefaultManagementFeesByVendor() * 100,
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "custom_management_fees_by_vendor",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.custom_management_fees_by_vendor'),
                                'value'       => optional($invoice_parameter)->getCustomManagementFeesByVendor() * 100,
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "discount_amount",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.discount_amount'),
                                'value'       => optional($invoice_parameter)->getDiscount(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'        => __('enterprise.invoiceParameter.application.views._form.discount_starts_at'),
                                'type'        => "date",
                                'name'        => "discount_starts_at",
                                'value'       => optional($invoice_parameter)->getDiscountStartsAt(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'        => __('enterprise.invoiceParameter.application.views._form.discount_ends_at'),
                                'type'        => "date",
                                'name'        => "discount_ends_at",
                                'value'       => optional($invoice_parameter)->getDiscountEndsAt(),
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "billing_floor_amount",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.billing_floor_amount'),
                                'value'       => optional($invoice_parameter)->getBillingFloorAmount(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'type'        => "number",
                                'step'        => 0.01,
                                'min'         => 0,
                                'name'        => "billing_cap_amount",
                                'required'    => true,
                                'text'        => __('enterprise.invoiceParameter.application.views._form.billing_cap_amount'),
                                'value'       => optional($invoice_parameter)->getBillingCapAmount(),
                            ])
                        </div>
                        <div class="col-6">
                            @form_group([
                                'text'        => __('enterprise.invoiceParameter.application.views._form.analytic_code'),
                                'type'        => "text",
                                'name'        => "analytic_code",
                                'value'       => optional($invoice_parameter)->getAnalyticCode(),
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label>
                                {{__('enterprise.invoiceParameter.application.views._form.customer_deadlines')}}
                            </label>
                            <select data-live-search="1" class="form-control shadow-sm selectpicker" name="customer_deadlines[]" multiple>
                                @foreach($deadlines as $deadline_id => $deadline_name)
                                    <option value="{{$deadline_id}}" @if(isset($selected_deadlines) && in_array($deadline_id, $selected_deadlines)) selected @endif>{{$deadline_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
