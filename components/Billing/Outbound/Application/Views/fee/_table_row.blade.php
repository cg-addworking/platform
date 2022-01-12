<tr>
    <td> {{ $fee->getNumber() }} </td>
    <td> {{ $fee->getLabel() }} </td>
    <td> @include('outbound_invoice::fee._type') </td>
    <td> {{ $fee->getVendor()->name ?? "n/a" }} </td>
    <td class="text-right"> @if($fee->getOutboundInvoiceItem()) @money($fee->getOutboundInvoiceItem()->getAmountBeforeTaxes()) @else n/a @endif</td>
    <td class="text-right"> @money($fee->getAmountBeforeTaxes()) </td>
    <td class="text-center"> {{ $fee->getVatRate()->display_name }} </td>
    <td class="text-right">
        @include('outbound_invoice::fee._actions')
    </td>
</tr>