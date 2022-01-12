@inject('ibanRepository', 'Components\Billing\PaymentOrder\Application\Repositories\IbanRepository')
@inject('enterpriseRepository', 'Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository')
@inject('outboundInvoiceRepository', 'Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository')
@inject('receivedPaymentRepository', "Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository")

<div id="selected-invoices">
    <ul>
        @if(! empty($receivedPaymentRepository->getPaymentOutbounds($received_payment)))
            @foreach($receivedPaymentRepository->getPaymentOutbounds($received_payment) as $payment)
                <li>
                    <input type="hidden" name="received_payment[outbound_invoice][]" value="{{ $payment->outboundInvoice->id }}">
                    <span>{{ $payment->outboundInvoice->getLabel() }}</span>
                    <button class="btn btn-outline-danger btn-sm invoice-delete ml-2">
                        <i class="fa fa-trash"></i>
                    </button>
                </li>
            @endforeach
        @endif
    </ul>
</div>

<div class="form-group">
    <label>Factures client (recherche)</label>
    <input type="search" min="2" class="form-control shadow-sm" id="search-invoice">
    <div>
        <ul id="list-invoice" class="list-group" style="display: block; position: absolute; z-index: 999;"></ul>
    </div>
</div>

<div class="form-group">
    <label>
        {{__('payment_order::received_payment.form.iban')}} <sup class=" text-danger font-italic">*</sup>
    </label>
    <select data-live-search="1" class="form-control shadow-sm selectpicker"  name="received_payment[iban]">
        <option value=""> {{__('payment_order::received_payment.form.no_selection')}} </option>
        @foreach($addworkingIbans as $iban_id => $iban_label)
            <option value="{{ $iban_id }}" @if($received_payment->getIban() && $received_payment->getIban()->id === $iban_id) selected @endif> {{ $iban_label }} </option>
        @endforeach
    </select>
</div>

@form_group([
    'text'     => "Référence bancaire",
    'type'     => "text",
    'required' => true,
    'name'     => "received_payment.bank_reference_payment",
    'value'    => optional($received_payment)->getBankReferencePayment()
])

@form_group([
    'text'     => "Montant",
    'type'     => "number",
    'step'     => 0.01,
    'required' => true,
    'id'       => "amount-container",
    'name'     => "received_payment.amount",
    'value'    => optional($received_payment)->getAmount()
])
<div class="alert alert-warning" role="alert" id="alert_amount" style="display: none">
    <p>{{__('payment_order::received_payment.form.first_paragraph')}}</p>
    <p>{{__('payment_order::received_payment.form.second_paragraph')}}<span id="received_payment"></span></p>
    <p>{{__('payment_order::received_payment.form.third_paragraph')}}<span id="_outbound_invoices_amount"></span></p>
</div>

@form_group([
    'text'     => "Date de réception",
    'type'     => "date",
    'required' => true,
    'name'     => "received_payment.received_at",
    'value'    => optional($received_payment)->getReceivedAt()
])

@push('scripts')
    <script>
        $('.selectpicker').selectpicker('refresh');

        var timeout = 0;
        $('#search-invoice').on('keyup',function() {
            var number_search = $(this).val();
            $('#list-invoice li').remove();

            clearTimeout(timeout)
            timeout = setTimeout(function() {
                if (number_search.length > 1) {
                    get_invoices(number_search)
                } else {
                    $('#list-invoice li').remove();
                }
            }, 250)
        });

        $("#list-invoice").on("click", "a", function(e){
            e.preventDefault();
            var invoice_id = $(this).parent().data("value");
            var invoice_label = $(this).parent().data("label");

            $('#selected-invoices ul').append('<li><input type="hidden" name="received_payment[outbound_invoice][]" value="'+invoice_id+'"><span>'+invoice_label+'</span><button class="btn btn-outline-danger btn-sm invoice-delete ml-2"><i class="fa fa-trash"></i></button></li>');
            $('#list-invoice li').remove();
        })

        $("#selected-invoices").on("click", '.invoice-delete', function() {
            $(this).closest('li').remove();
        })

        var get_invoices = function(value) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('addworking.billing.received_payment.search_outbound_invoices', $enterprise) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    number: value
                },
                beforeSend: function () {
                    $('#list-invoice li').remove();
                },
                success: function(response) {
                    $.each(response.body, function(id, label) {
                        $('#list-invoice').append('<li data-value="'+id+'" data-label="'+label+'" class="list-group-item list-group-item-action"><a href="#">'+label+'</a></li>');
                    });
                },
            });
        }

        var check_received_payment_amount = function (amount, outbound_invoices, enterprise_id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('addworking.billing.received_payment.check_received_payment_amount_ajax', $enterprise) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    enterprise_id: enterprise_id,
                    outbound_invoices: outbound_invoices
                },
                success: function(response) {
                    if (Number(response.data) !== Number(amount)) {
                        $('#alert_amount').css('display', 'block');
                        $('#received_payment').html(amount+" €");
                        $('#_outbound_invoices_amount').html(response.data+" €");
                    } else {
                        $('#alert_amount').css('display', 'none');
                    }
                },
            });
        }

        $("#amount-container").on('change', function() {
            var amount = $(this).val();
            var outbound_invoices = $("input[name='received_payment[outbound_invoice][]']")
                .map(function(){
                    return $(this).val();
                }).get();
            var enterprise_id = '{{ $enterprise->id }}';
            check_received_payment_amount(amount, outbound_invoices, enterprise_id);
        });

    </script>
@endpush
