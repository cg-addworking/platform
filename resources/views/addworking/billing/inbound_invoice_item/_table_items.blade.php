<table class="table table-striped table-hover">
    <colgroup>
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
    </colgroup>
    <thead>
    <tr>
        <th>{{ __('addworking.billing.inbound_invoice_item._table_items.label') }}</th>
        <th>{{ __('addworking.billing.inbound_invoice_item._table_items.amount') }}</th>
        <th>{{ __('addworking.billing.inbound_invoice_item._table_items.unit_price') }}</th>
        <th>{{ __('addworking.billing.inbound_invoice_item._table_items.vat_rate') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($inbound_invoice_items as $item)
        <tr>
            <td>{{ $item->label }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_price ." €"}}</td>
            <td>{{ sprintf('%.2f', $item->vat_rate * 100) }} %</td>
        </tr>
    @endforeach
    </tbody>
</table>
