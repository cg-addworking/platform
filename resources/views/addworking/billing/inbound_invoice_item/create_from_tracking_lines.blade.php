@extends('foundation::layout.app.create', ['method' => 'post', 'action' => route('addworking.billing.inbound_invoice_item.store_from_tracking_line', @compact('enterprise', 'inbound_invoice'))])

@section('title', __('addworking.billing.inbound_invoice_item.create_from_tracking_lines.mission_followups_affected_by_this_invoice'))

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.return') ."|href:{$inbound_invoice_item->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.invoice_lines') ."|href:{$inbound_invoice_item->routes->index}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.create') ."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('upload') {{ __('addworking.billing.inbound_invoice_item.create_from_tracking_lines.mission_followups_affected_by_this_invoice') }}</legend>
        <div class="col-md-12">
            <div style="display: none" id="count-selected-lines" class="alert alert-primary" role="alert">
                <p class="mb-0">
                    {{ __('addworking.billing.inbound_invoice_item.create_from_tracking_lines.number_of_lines_selected') }}<b class="checked-count">0</b><br>
                    {{ __('addworking.billing.inbound_invoice_item.create_from_tracking_lines.total_amount_excluding_taxes_of_selected_lines') }}<b><span class="checked-total">0</span> €</b><br>
                </p>
            </div>
        </div>
        @include('addworking.billing.inbound_invoice_item._table_tracking_lines')
    </fieldset>

    @button(__('addworking.billing.inbound_invoice_item.create_from_tracking_lines.associate') ."|icon:save|type:submit")
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#select-all').click(function () {
                $('#tracking-list input:checkbox').prop('checked', $(this).is(':checked'));
                update_checked_counter();
            });

            $('#tracking-list input:checkbox').change(update_checked_counter);
            update_checked_counter();
        })

        function update_checked_counter() {
            var count = $('#tracking-list input:checkbox:checked:not(#select-all)').length;
            var total = 0;
            $('#tracking-list').find('input:checkbox:checked:not(#select-all)').each(function () {
                total += parseFloat($(this).closest('tr').find('.total-amount').text());
            });

            $('.checked-count').text(count);
            $('.checked-total').text(total);
            $('#count-selected-lines')[count == 0 ? 'hide': 'show']();
        }
    </script>
@endpush
