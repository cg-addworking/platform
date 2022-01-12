<tr class="bg-light">
    <td colspan="99" class="text-center p-5">
        <p class="mb-4">{{ __('addworking.billing.inbound_invoice._table_row_empty.statement_prefix') }} {{ $inbound_invoice->enterprise->views->link }} {{ __('addworking.billing.inbound_invoice._table_row_empty.statement_postfix') }}</p>

        @can('create', [inbound_invoice_item(), $inbound_invoice])
            @button(sprintf(__('addworking.billing.inbound_invoice._table_row_empty.add_from_tracking_lines') ."|href:%s|icon:plus|color:outline-success|outline|sm|mr:2", route('addworking.billing.inbound_invoice_item.create_from_tracking_line', [$inbound_invoice->enterprise, $inbound_invoice])))
        @endcan
    </td>
</tr>
