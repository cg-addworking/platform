<fieldset class="mt-2 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.billing.inbound_invoice._form.invoice_properties') }}</legend>
    <div class="row">
        <div class="col-6">
            @form_group([
                'text'         => __('addworking.billing.inbound_invoice.before_create.customer'),
                'type'         => "select",
                'name'         => "inbound_invoice.customer_id",
                'options'      => $inbound_invoice->enterprise->customers()->orderBy('name')->pluck('name', 'id'),
                'selectpicker' => true,
                'search'       => true,
                'required'     => true,
                'id'           => 'select-customer',
            ])
        </div>
        <div class="col-6">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice.before_create.period'),
                'type'        => "select",
                'name'        => "inbound_invoice.month",
                'options'     => array_mirror($inbound_invoice->getAvailableMonths()),
                'value'       => $last_month ?? optional($inbound_invoice)->month,
                'required'    => true,
                'help'        => __('addworking.billing.inbound_invoice.before_create.help_text'),
                'id'          => "select-period",
            ])
        </div>
        <div class="col-4">
            @form_group([
            'text'        => __('addworking.billing.inbound_invoice._form.date_of_invoice'),
            'type'        => "date",
            'name'        => "inbound_invoice.invoiced_at",
            'value'       => optional($inbound_invoice)->invoiced_at,
            'required'    => true,
            ])
        </div>
        <div class="col-4">
            @form_group([
            'text'        => __('addworking.billing.inbound_invoice._form.number'),
            'type'        => "text",
            'name'        => "inbound_invoice.number",
            'value'       => optional($inbound_invoice)->number,
            'required'    => true,
            ])
        </div>
        <div class="col-4">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice._form.payment_deadline'),
                'type'        => "select",
                'name'        => "inbound_invoice.deadline_id",
                'value'       => optional($inbound_invoice->deadline()->first())->id,
                'required'    => true,
                'id'          => "select-payment-deadline",
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice._form.amount_excluding_taxes'),
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.amount_before_taxes",
                'value'       => optional($inbound_invoice)->amount_before_taxes,
                'required'    => true,
            ])
        </div>
        <div class="col-4">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice._form.amount_of_taxes'),
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.amount_of_taxes",
                'value'       => optional($inbound_invoice)->amount_of_taxes,
                'required'    => true,
            ])
        </div>
        <div class="col-4">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice._form.amount_all_taxes_included'),
                'type'        => "number",
                'step'        => ".01",
                'name'        => "inbound_invoice.amount_all_taxes_included",
                'value'       => optional($inbound_invoice)->amount_all_taxes_included,
                'required'    => true,
                'id'          => "input-amount-all-taxes-included"
            ])
        </div>
    </div>
    <div class="row" id="container-tracking-lines">
        <div class="col-md-12">
            <label>{{ __('addworking.billing.inbound_invoice._form.tracking_lines') }}</label>   
            <table class="table table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="45%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <th></th>
                    <th>{{ __('addworking.billing.inbound_invoice._form.tracking_lines_description') }}</th>
                    <th>{{ __('addworking.billing.inbound_invoice._form.tracking_lines_quantity') }}</th>
                    <th>{{ __('addworking.billing.inbound_invoice._form.tracking_lines_unit_price') }}</th>
                    <th>{{ __('addworking.billing.inbound_invoice._form.tracking_lines_amount_before_taxes') }}</th>
                    <th>{{ __('addworking.billing.inbound_invoice._form.tracking_lines_vat_rate') }}</th>
                </thead>
                <tbody id="container-tracking-line">
                </tbody>
            </table>
            <div class="col-md-12"><input type="checkbox" name="inbound_invoice[items_not_found]" value="true" id="no_items_found"> <label for="no_items_found">{{ __('addworking.billing.inbound_invoice._form.tracking_lines_not_found') }}</label></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @form_group([
                'text'        => __('addworking.billing.inbound_invoice._form.note'),
                'type'        => "textarea",
                'name'        => "inbound_invoice.note",
                'value'       => optional($inbound_invoice)->note,
                'required'    => false,
            ])
        </div>
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body"
                     @if(! in_array($inbound_invoice->status, ["to_validate", "pending"])) title="Il n'est possible de changer l'option d'affacturage qu'aux états : à validier et en attente." @endif>
                    <span @if(! in_array($inbound_invoice->status, ["to_validate", "pending"])) style="color: #6c757d" @endif>{{ __('addworking.billing.inbound_invoice._form.is_factoring_message') }}</span><br>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="inbound_invoice[is_factoring]" class="custom-control-input" id="custom-check-factor" @if($inbound_invoice->is_factoring) checked @endif
                        @if(! in_array($inbound_invoice->status, ["to_validate", "pending"])) disabled @endif>
                        <label class="custom-control-label" for="custom-check-factor">{{ __('addworking.billing.inbound_invoice._form.is_factoring_check') }}</label>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning mt-2" role="alert" id="alert-factor">
                <span class="font-weight-bold">
                    {{ __('addworking.billing.inbound_invoice._form.is_factoring_alert_line_1', ['iban' => $inbound_invoice->enterprise->iban->formatted_label]) }}<br>
                    {{ __('addworking.billing.inbound_invoice._form.is_factoring_alert_line_2') }}
                    <a href="{{ route('enterprise.iban.create', $inbound_invoice->enterprise) }}" target="_blank">{{ __('addworking.billing.inbound_invoice._form.replace_rib') }}</a>
                </span>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="mt-2 pt-2">
    <legend class="text-primary h5">@icon('upload') {{ __('addworking.billing.inbound_invoice._form.file') }}</legend>

    @if ($inbound_invoice->file->exists)
        <label>{{ __('addworking.billing.inbound_invoice._form.current_file') }} </label>
        <a href="{{ $inbound_invoice->file->routes->download }}" class="btn btn-primary btn-sm">@icon('download|mr:2') {{ $inbound_invoice->file->basename }}</a>
        @if (! $inbound_invoice->isLocked())
            <a href="#file" class="btn btn-danger btn-sm" data-toggle="collapse">@icon('times|mr:2') {{ __('addworking.billing.inbound_invoice._form.replace') }}</a>
        @endif
    @endif

    <div id="file" class="collapse show">
        @form_group([
        'text'        => __('addworking.billing.inbound_invoice._form.file'),
        'type'        => "file",
        'name'        => "file.content",
        'accept'      => 'application/pdf',
        'required'    => ! $inbound_invoice->file->exists,
        ])
    </div>
</fieldset>

@support
    @include('addworking.billing.inbound_invoice._form_support')
@endsupport

@push('scripts')
    <script type="text/javascript">
        $(function () {
            let fields = {
                amount_before_taxes: $(':input[name="inbound_invoice[amount_before_taxes]"]'),
                amount_of_taxes : $(':input[name="inbound_invoice[amount_of_taxes]"]'),
                amount_all_taxes_included : $(':input[name="inbound_invoice[amount_all_taxes_included]"]'),
            };

            let update_amount_all_taxes_included = function () {
                let num = parseFloat(fields.amount_before_taxes.val() || "0") + parseFloat(fields.amount_of_taxes.val() || "0");
                fields.amount_all_taxes_included.val(Math.round((num + Number.EPSILON) * 100) / 100);
            };

            fields.amount_before_taxes.bind('keyup mouseup change', update_amount_all_taxes_included);
            fields.amount_of_taxes.bind('keyup mouseup change', update_amount_all_taxes_included);
        });

        $(document).ready(function() {
            if ($('#custom-check-factor').is(":checked")) {
                $("#alert-factor").show();
            } else {
                $("#alert-factor").hide();
            }

            $('#custom-check-factor').click(function() {
                $("#alert-factor").toggle("slow");
            });

            var get_vendor_deadlines = function(customer_id) {
                var vendor_id = '{{$enterprise->id}}';

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('addworking.billing.inbound_invoice.get_vendor_deadlines', $enterprise) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        vendor_id: vendor_id,
                        customer_id: customer_id,
                    },
                    beforeSend: function () {
                        $("#select-payment-deadline option").remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, display_name) {
                            $("#select-payment-deadline").append('<option value="'+id+'">'+display_name+'</option>');
                        });
                    },
                });
            }


            var get_tracking_lines = function(customer_id, period_id) {
                var vendor_id = '{{$enterprise->id}}';
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('addworking.billing.inbound_invoice.get_tracking_lines', $enterprise) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        vendor_id: vendor_id,
                        customer_id: customer_id,
                        period_id: period_id,
                    },
                    beforeSend: function () {
                        $("#container-tracking-line tr").remove();
                        $("#container-tracking-lines").hide();
                    },
                    success: function(response) {
                        if (response.data.invoice_parameter) {
                            $("#container-tracking-lines").show();
                            if (typeof response.data.tracking_line === "undefined") {
                                $("#container-tracking-line").append('<tr><td colspan="6">Aucun élément facturable sur cette période.</td></tr>');
                            }
                            $.each(response.data.tracking_line, function(id, tracking_line) {
                                $("#container-tracking-line").append('<tr><td><input type="checkbox" name="inbound_invoice[items]['+id+'][invoiceable_id]" value="'+id+'"></td><td>'+tracking_line.label+'</td><td>'+tracking_line.unit_price+'</td><td>'+tracking_line.quantity+'</td><td>'+tracking_line.amount+'</td><td class="container-vat-rate"><select class="custom-select custom-select-sm" name="inbound_invoice[items]['+id+'][vat_rate_id]"></select></td></tr>');
                            });
                            $.each(response.data.vat_rate, function(id, display_name) {
                                $(".container-vat-rate select").append('<option value="'+id+'">'+display_name+'</option>')
                            });
                        }
                    },

                });
            };

            get_vendor_deadlines($('#select-customer').val());
            get_tracking_lines($('#select-customer').val(), $('#select-period').val());

            $('#select-customer').on('change', function(){
                get_vendor_deadlines($(this).val());
                get_tracking_lines($(this).val(), $('#select-period').val());
            });

            $('#select-period').on('change', function(){
                get_tracking_lines($('#select-customer').val(), $(this).val());
            });
        });
    </script>
@endpush
