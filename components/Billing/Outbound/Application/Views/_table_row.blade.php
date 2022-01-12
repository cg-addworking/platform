<tr>
    @support
        <td class="text-center">
            @can('publish', [get_class($outboundInvoice), $enterprise, $outboundInvoice])
                <a class="btn" href="{{ route('addworking.billing.outbound.publish', [$enterprise, $outboundInvoice]) }}">
                    @icon('eye-slash|mr:3|color:danger')
                </a>
            @endcan
            @can('unpublish', [get_class($outboundInvoice), $enterprise, $outboundInvoice])
                <a class="btn text-center" href="{{ route('addworking.billing.outbound.unpublish', [$enterprise, $outboundInvoice]) }}">
                    @icon('eye|mr:3|color:success')
                </a>
            @endcan
        </td>
    @endsupport
    <td> {{ $outboundInvoice->getFormattedNumber() }} </td>
    <td class="text-center"> @date($outboundInvoice->getInvoicedAt()) </td>
    <td class="text-center"> @date($outboundInvoice->getDueAt()) </td>
    <td class="text-center"> {{ $outboundInvoice->getMonth() }} </td>
    <td class="text-center"> {{ $outboundInvoice->getDeadline()->display_name ?? "n/a"}} </td>
    <td class="text-center"> @money($outboundInvoice->getAmountBeforeTaxes()) </td>
    <td class="text-center"> @money($outboundInvoice->getAmountOfTaxes()) </td>
    <td class="text-center"> @money($outboundInvoice->getAmountAllTaxesIncluded()) </td>
    <td class="text-center">
        @include('outbound_invoice::_status')
    </td>
    <td class="text-right">
        @include('outbound_invoice::_actions')
    </td>
</tr>