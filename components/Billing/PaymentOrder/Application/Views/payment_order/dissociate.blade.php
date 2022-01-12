@extends('foundation::layout.app.create', ['action' => route('addworking.billing.payment_order.store_dissociate', [$enterprise, $payment_order]), 'method' => "POST"])

@section('title', __('addworking.components.billing.outbound.payment_order.dissociate.title'))

@section('toolbar')
    @button(__('addworking.components.billing.outbound.payment_order.dissociate.return')."|href:".route('addworking.billing.payment_order.show', [$enterprise, $payment_order])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('associate', $payment_order)
        @button(__('addworking.components.billing.outbound.payment_order.dissociate.left_to_pay')."|href:".route('addworking.billing.payment_order.index_associate', [$enterprise, $payment_order])."|icon:file-invoice|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "dissociate"])
@endsection

@section('form')
    @if($items->count() > 0)
        <div class="mb-4">
            @can('storeDissociate', $payment_order)
            <button type="submit" class="btn btn-outline-success btn-sm" style="display: none" id="button-submit">
                <i class="fa fa-fw mr-2 fa-link"></i> {{ __('addworking.components.billing.outbound.payment_order.dissociate.select') }}
            </button>
            @endcan
        </div>
        <div class="table-responsive" id="invoice-list" style="min-height: 500px">
            <table class="table table-hover">
                <colgroup>
                    @can('storeDissociate', $payment_order)
                        <col width="5%">
                    @endcan
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                @can('storeDissociate', $payment_order)
                    <th class="text-center"><input type="checkbox" id="select-all"></th>
                @endcan
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.vendor')."|not_allowed")
                @th(__('addworking.components.billing.outbound.payment_order.associate.outbound_invoice_number')."|not_allowed")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.invoice_number')."|not_allowed|class:text-center")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.billing_period')."|not_allowed|class:text-center")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.deadline')."|not_allowed|class:text-center")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.amount_without_taxes')."|not_allowed|class:text-center")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.amount_all_taxes_included')."|not_allowed|class:text-center")
                @th(__('addworking.components.billing.outbound.payment_order.dissociate.status')."|not_allowed|class:text-center")
                @can('storeDissociate', $payment_order)
                    @th(__('addworking.components.billing.outbound.payment_order.dissociate.actions')."|not_allowed|class:text-center")
                @endcan
                </thead>
                <tbody>
                @foreach ($items as $inbound_invoice)
                    <tr>
                        @can('storeDissociate', $payment_order)
                        <td class="text-center"><input type="checkbox" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}"></td>
                        @endcan
                        <td><a href="{{ $inbound_invoice->enterprise->routes->show }}" target="_blank">{{ $inbound_invoice->enterprise->name }}</a></td>
                        <td>{{ $inbound_invoice->outboundInvoice->getFormattedNumber() }}</td>
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
                        @can('storeDissociate', $payment_order)
                            <td class="text-center">
                                <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                    @icon('unlink|mr-3') <span>{{ __('addworking.components.billing.outbound.payment_order.dissociate.dissociate') }}</span>
                                </a>

                                @push('forms')
                                    <form name="{{ $name }}" action="{{ route('addworking.billing.payment_order.store_dissociate', [$enterprise, $payment_order]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}">
                                    </form>
                                @endpush
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <span>{{ __('addworking.components.billing.outbound.payment_order.dissociate.customer') }} <b>{{ $enterprise->name }}</b> {{ __('addworking.components.billing.outbound.payment_order.dissociate.table_row_empty') }}<br>.</span>
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

