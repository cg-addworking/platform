@extends('foundation::layout.app.create', ['action' => $inbound_invoice->routes->store, 'enctype' => "multipart/form-data"])

@section('title', __('addworking.billing.inbound_invoice.create.new_invoice'))

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice.create.return') ."|href:{$inbound_invoice->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice.create.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice.create.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.create.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.create.create') ."|active")
@endsection

@section('form')
    @include('addworking.billing.inbound_invoice._warning')

    <input type="hidden" name="inbound_invoice[customer_id]" value="{{ $inbound_invoice->customer->id }}">
    <input type="hidden" name="inbound_invoice[month]" value="{{ $inbound_invoice->month }}">

    {{ $inbound_invoice->views->form(['enterprise' => $enterprise, 'last_month' => $last_month]) }}

    <div class="text-right my-5">
        @button(__('addworking.billing.inbound_invoice.create.create') ."|type:submit|color:success|shadow|icon:plus")
    </div>
@endsection

@push('scripts')
    <script>
        const is_custumer = '{{(bool) $enterprise->isCustomer()}}';
        const is_business_plus = '{{(bool) $inbound_invoice->customer->isBusinessPlus()}}';

        if (is_custumer && ! is_business_plus) {
            const enterprise_country = '{{$enterprise->getCountry()}}';

            if (enterprise_country !== 'de') {
                $('#fr_be_billing_address').css('display', 'block');
                $('#deutschland_billing_address').css('display', 'none');
            } else {
                $('#deutschland_billing_address').css('display', 'block');
                $('#fr_be_billing_address').css('display', 'none');
            }
        } else {
            const selected_customer = $("#select-customer option:selected").val();

            const check_enterprise_country = function (value) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('addworking.billing.received_payment.check_customer_country_ajax', $enterprise) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        customer_id: value,
                    },
                    success: function(response) {
                        if (response.data !== "de") {
                            $('#fr_be_billing_address').css('display', 'block');
                            $('#deutschland_billing_address').css('display', 'none');
                        } else {
                            $('#deutschland_billing_address').css('display', 'block');
                            $('#fr_be_billing_address').css('display', 'none');
                        }
                    },
                });
            };

            check_enterprise_country(selected_customer);

            $('#select-customer').on('change', function() {
                check_enterprise_country($(this).val());
            });
        }
    </script>
@endpush