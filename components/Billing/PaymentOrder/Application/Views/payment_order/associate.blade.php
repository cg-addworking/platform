@inject('receivedPaymentRepository', 'Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository')

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.payment_order.store_associate', [$enterprise, $payment_order]), 'method' => "POST"])

@section('title', __('addworking.components.billing.outbound.payment_order.associate.title'))

@section('toolbar')
    @button(__('addworking.components.billing.outbound.payment_order.associate.return')."|href:".route('addworking.billing.payment_order.index_dissociate', [$enterprise, $payment_order])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "associate"])
@endsection

@section('form')
    @if($items->count() > 0)
        <div class="mb-4">
            @support
                <button type="submit" class="btn btn-outline-success btn-sm" style="display: none" id="button-submit">
                    <i class="fa fa-fw mr-2 fa-link"></i> {{ __('addworking.components.billing.outbound.payment_order.associate.select') }}
                </button>
            @endsupport
        </div>
        <div class="table-responsive" id="invoice-list" style="min-height: 500px">
            <table class="table table-hover">
                <colgroup>
                    @support
                        <col width="5%">
                    @endsupport
                    <col width="15%">
                    <col width="13%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <col width="10%">
                </colgroup>
                <thead>
                    @support
                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                    @endsupport
                    @th(__('addworking.components.billing.outbound.payment_order.associate.vendor')."|not_allowed")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.outbound_invoice_number')."|not_allowed")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.invoice_number')."|not_allowed")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.billing_period')."|not_allowed|class:text-center")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.deadline')."|not_allowed|class:text-center")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.amount_without_taxes')."|not_allowed|class:text-center")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.amount_all_taxes_included')."|not_allowed|class:text-center")
                    @th(__('addworking.components.billing.outbound.payment_order.associate.status')."|not_allowed|class:text-center")
                    @support
                        @th(__('addworking.components.billing.outbound.payment_order.associate.actions')."|not_allowed|class:text-center")
                    @endsupport
                </thead>
                <tbody>
                @foreach ($items as $inbound_invoice)
                    <tr @if($inbound_invoice->is_factoring) class="table-warning" @endif>
                        @support
                            <td class="text-center"><input type="checkbox" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}"></td>
                        @endsupport
                        <td><a href="{{ $inbound_invoice->enterprise->routes->show }}" target="_blank">{{ $inbound_invoice->enterprise->name }}</a></td>
                        <td>
                            @support
                                @if ($receivedPaymentRepository->hasReceivedPayment($inbound_invoice->outboundInvoice))
                                    <span class="badge badge-success" data-toggle="tooltip" data-placement="bottom" title="Paiement reçu (N°: {{ $receivedPaymentRepository->getReceivedPaymentOf($inbound_invoice->outboundInvoice)->getNumber() }})"><i class="fas fa-check"></i></span>
                                @else
                                    <span class="badge badge-warning" data-toggle="tooltip" data-placement="bottom" title="Paiement manquant"><i class="fas fa-times"></i></span>
                                @endif
                            @endsupport
                            {{ $inbound_invoice->outboundInvoice->getFormattedNumber() }}
                        </td>
                        <td><a href="{{ $inbound_invoice->routes->show }}" target="_blank">{{ $inbound_invoice->number }}</a></td>
                        <td class="text-center"> {{ $inbound_invoice->month }} </td>
                        <td class="text-center"> {{ $inbound_invoice->deadline()->first()->display_name }} </td>
                        <td class="text-center">@money($inbound_invoice->amount_before_taxes)</td>
                        <td class="text-center">@money($inbound_invoice->amount_all_taxes_included)</td>
                        <td class="text-center">
                            @include('addworking.billing.inbound_invoice._status')
                            @if($inbound_invoice->is_factoring)
                                <span class="badge badge-pill badge-warning">{{ __('addworking.components.billing.outbound.payment_order.associate.is_factoring') }}</span>
                            @endif
                        </td>
                        @support
                            <td class="text-center">
                                @can('associate', $payment_order)
                                    <a class="btn btn-sm btn-outline-success" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                        @icon('link|mr-3') <span>{{ __('addworking.components.billing.outbound.payment_order.associate.associate') }}</span>
                                    </a>

                                    @push('forms')
                                        <form name="{{ $name }}" action="{{ route('addworking.billing.payment_order.store_associate', [$enterprise, $payment_order]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}">
                                        </form>
                                    @endpush
                                @endcan
                            </td>
                        @endsupport
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <span>{{ __('addworking.components.billing.outbound.payment_order.associate.customer') }} <b>{{ $enterprise->name }}</b> {{ __('addworking.components.billing.outbound.payment_order.associate.table_row_empty') }}<br>.</span>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function checked_counter() {
            var count = $('#invoice-list input:checkbox:checked:not(#select-all)').length;
            $('#button-submit')[count == 0 ? 'hide': 'show']();
        }

        $(function () {
            $('#select-all').click(function () {
                $('#invoice-list input:checkbox').prop('checked', $(this).is(':checked'));
                checked_counter()
            });

            $('#invoice-list input:checkbox').change(checked_counter);
        })
    </script>
@endpush

