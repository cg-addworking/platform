@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.credit_note.associate', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.item.associate_credit_line.title'))

@section('toolbar')
    @button(__('billing.outbound.application.views.item.associate_credit_line.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "indexCreditLine"])
@endsection

@section('form')
    @if($items->count() > 0)
        <div class="mb-4">
            <button type="submit" class="btn btn-outline-success btn-sm" style="display: none" id="button-submit">
                @icon('plus|mr-2') {{ __('billing.outbound.application.views.item.associate_credit_line.label_1') }}
            </button>
        </div>
        <div class="table-responsive" id="item-list">
            <table class="table table-hover">
                <colgroup>
                    <col width="5%">
                    <col width="5%">
                    <col width="20%">
                    <col width="5%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                </colgroup>
                <thead>
                    <th class="text-center"><input type="checkbox" id="select-all"></th>
                    @th(__('billing.outbound.application.views.item.associate_credit_line.number')."|not_allowed")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.service_provider')."|not_allowed")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.invoice_number')."|not_allowed")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.label')."|not_allowed")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.unit_price')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.quantity')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.amount_ht')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.vat_rate')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.item.associate_credit_line.action')."|not_allowed|class:text-right")
                </thead>
                <tbody>
                @foreach ($items as $outbound_invoice_item)
                    <tr>
                        <td class="text-center"><input type="checkbox" name="outbound_invoice_item[id][]" value="{{ $outbound_invoice_item->id }}"></td>
                        <td> {{ $outbound_invoice_item->getNumber() }} </td>
                        <td> {{ $outbound_invoice_item->getVendor()->name ?? "n/a"}} </td>
                        <td> {{ $outbound_invoice_item->getInboundInvoice()->number ?? "n/a" }} </td>
                        <td> {{ $outbound_invoice_item->getLabel() }} </td>
                        <td class="text-center"> {{$outbound_invoice_item->getUnitPrice(). "€"}} </td>
                        <td class="text-center"> {{ $outbound_invoice_item->getQuantity() }} </td>
                        <td class="text-center"> @money($outbound_invoice_item->getAmountBeforeTaxes()) </td>
                        <td class="text-center"> {{ $outbound_invoice_item->getVatRate()->display_name }} </td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-outline-success" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                @icon('plus|mr-3') <span>{{ __('billing.outbound.application.views.item.associate_credit_line.create') }}</span>
                            </a>

                            @push('forms')
                                <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.credit_note.associate', [$enterprise, $outboundInvoice]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="outbound_invoice_item[id][]" value="{{ $outbound_invoice_item->id }}">
                                </form>
                            @endpush
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.item.associate_credit_line.text_1') }} {{  $parentOutboundInvoice->getNumber() }} {{ __('billing.outbound.application.views.item.associate_credit_line.text_2') }}</span>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function checked_counter() {
            var count = $('#item-list input:checkbox:checked:not(#select-all)').length;
            $('#button-submit')[count == 0 ? 'hide': 'show']();
        }

        $(function () {
            $('#select-all').click(function () {
                $('#item-list input:checkbox').prop('checked', $(this).is(':checked'));
                checked_counter()
            });

            $('#item-list input:checkbox').change(checked_counter);
        })
    </script>
@endpush
