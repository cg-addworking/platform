@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.credit_note.associate_fees', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.fee.associate_credit_fees.title'))

@section('toolbar')
    @button(__('billing.outbound.application.views.fee.associate_credit_fees.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::fee._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @if($items->count() > 0)
        <div class="mb-4">
            <button type="submit" class="btn btn-outline-danger btn-sm" style="display: none" id="button-submit">
                @icon('minus-square|mr-2') {{ __('billing.outbound.application.views.fee.associate_credit_fees.cancel_selected') }}
            </button>
        </div>
        <div class="table-responsive" id="item-list">
            <table class="table table-hover">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="20%">
                    <col width="10%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                </colgroup>
                <thead>
                    @include('outbound_invoice::fee._table_head_associate')
                </thead>
                <tbody>
                    @foreach ($items as $fee)
                        @include('outbound_invoice::fee._table_row_associate', compact('items'))
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.fee.associate_credit_fees.text_1') }} {{  $parentOutboundInvoice->getNumber() }} {{ __('billing.outbound.application.views.fee.associate_credit_fees.text_2') }}</span>
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
