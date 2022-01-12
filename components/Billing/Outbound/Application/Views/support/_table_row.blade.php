<tr>
    <td class="text-center">
        @can('publish', [get_class($outboundInvoice), $outboundInvoice->getEnterprise(), $outboundInvoice])
            <a class="btn" href="{{ route('addworking.billing.outbound.publish', [$outboundInvoice->getEnterprise(), $outboundInvoice]) }}">
                @icon('eye-slash|mr:3|color:danger')
            </a>
        @endcan
        @can('unpublish', [get_class($outboundInvoice), $outboundInvoice->getEnterprise(), $outboundInvoice])
            <a class="btn text-center" href="{{ route('addworking.billing.outbound.unpublish', [$outboundInvoice->getEnterprise(), $outboundInvoice]) }}">
                @icon('eye|mr:3|color:success')
            </a>
        @endcan
    </td>
    <td> {{ $outboundInvoice->getFormattedNumber() }} </td>
    <td> {{ $outboundInvoice->enterprise->name }} </td>
    <td class="text-center"> @date($outboundInvoice->invoiced_at) </td>
    <td class="text-center"> @date($outboundInvoice->due_at) </td>
    <td class="text-center"> {{ $outboundInvoice->getMonth() }} </td>
    <td class="text-center"> {{ $outboundInvoice->getDeadline()->display_name ?? "n/a"}} </td>
    <td class="text-center"> @money($outboundInvoice->getAmountBeforeTaxes()) </td>
    <td class="text-center"> @money($outboundInvoice->getAmountOfTaxes()) </td>
    <td class="text-center"> @money($outboundInvoice->getAmountAllTaxesIncluded()) </td>
    <td class="text-center">
        @include('outbound_invoice::_status')
    </td>
    <td class="text-right">
        @include('outbound_invoice::_actions', ['enterprise' => $outboundInvoice->enterprise])
    </td>
</tr>