<tr>
    <td>{{ $inbound_invoice_item->label }}</td>
    <td class="text-center">
        @if(isset($inbound_invoice_item->invoiceable) && isset($inbound_invoice_item->invoiceable->missionTracking))
            @component('foundation::layout.app._link', ['model' => $inbound_invoice_item->invoiceable->missionTracking->mission, 'property' => 'number'])
            @endcomponent
        @endif
    </td>
    <td class="text-center">
        @if(isset($inbound_invoice_item->invoiceable) && isset($inbound_invoice_item->invoiceable->missionTracking))
            <a href="{{ $inbound_invoice_item->invoiceable->missionTracking->routes->show }}">
                @include('addworking.mission.mission_tracking_line._status', ['status' => $inbound_invoice_item->invoiceable->validation_customer])
            </a>
        @endif
    </td>
    <td class="text-center">
        @if(isset($inbound_invoice_item->invoiceable) && isset($inbound_invoice_item->invoiceable->missionTracking))
            <a href="{{ $inbound_invoice_item->invoiceable->missionTracking->routes->show }}">
                @include('addworking.mission.mission_tracking_line._status', ['status' => $inbound_invoice_item->invoiceable->validation_vendor])
            </a>
        @endif
    </td>
    <td class="text-center">{{ $inbound_invoice_item->unit_price ." €"}}</td>
    <td class="text-center">{{ $inbound_invoice_item->quantity }}</td>
    <td class="text-center">@money($inbound_invoice_item->getAmountBeforeTaxes())</td>
    <td class="text-center">@percentage($inbound_invoice_item->vatRate->value)</td>
    <td class="text-right">{{ $inbound_invoice_item->views->actions }}</td>
</tr>
