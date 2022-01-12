<div class="table-responsive">
    <table class="table table-hover" id="tracking-list">
        <colgroup>
            <col width="5">
            <col width="30%">
            <col width="5%">
            <col width="13%">
            <col width="5%">
            <col width="5%">
            <col width="9%">
            <col width="5%">
            <col width="9%">
            <col width="14%">
        </colgroup>
        <thead>
            <th class="text-center">
                <input type="checkbox" id="select-all">
            </th>
            <th>{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.purpose_of_mission_monitoring_line') }}</th>
            <th>{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.mission_number') }}</th>
            <th>{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.period') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.customer_validation') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.provider_validation') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.unit_price') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.amount') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.total_ht') }}</th>
            <th class="text-center">{{ __('addworking.billing.inbound_invoice_item._table_tracking_lines.vat_rate') }}</th>
        </thead>
        <tbody>
            @forelse($tracking_lines as $line)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="inbound_invoice[items][{{ $line->id }}][invoiceable_id]" value="{{ $line->id }}">
                    </td>
                    <td>{{ $line->label }}</td>
                    <td>{{ $line->missionTracking->mission->number }}</td>
                    <td>{{ $line->missionTracking->milestone->label }}</td>
                    <td class="text-center">@include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_customer])</td>
                    <td class="text-center">@include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_vendor])</td>
                    <td class="text-center">{{ $line->unit_price ." €"}}</td>
                    <td class="text-center">{{ $line->quantity }}</td>
                    <td class="text-center"><span class="total-amount">{{ number_format($line->unit_price*$line->quantity, 2, '.', '') }}</span> €</td>
                    <td>
                        @form_control([
                        'type'     => "select",
                        'class'    => "form-control-sm",
                        'name'     => "inbound_invoice[items][{$line->id}][vat_rate_id]",
                        'options'  => vat_rate([])->get()->sortByDesc('value')->pluck('display_name', 'id'),
                        'required' => true,
                        ])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        <div class="p-5">
                            <i class="fa fa-frown-o"></i> @lang('messages.empty')
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
