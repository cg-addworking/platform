<tr>
    <td class="text-center"> {{ $outboundInvoiceItem->getNumber() }} </td>
    <td> {{ $outboundInvoiceItem->getInboundInvoice()->enterprise->name ?? "n/a"}} </td>
    <td>
        @if($outboundInvoiceItem->getInboundInvoice()->exists)
            <a href="{{ route('addworking.billing.inbound_invoice.show', ['enterprise' => $outboundInvoiceItem->getInboundInvoice()->enterprise, 'inbound_invoice' => $outboundInvoiceItem->getInboundInvoice()]) }}" target="_blank"> {{ $outboundInvoiceItem->getInboundInvoice()->number }} </a>
        @else
            n/a
        @endif
    </td>
    <td> {{ $outboundInvoiceItem->getLabel() }} </td>
    <td class="text-center"> {{$outboundInvoiceItem->getUnitPrice() . "€"}} </td>
    <td class="text-center"> {{ $outboundInvoiceItem->getQuantity() }} </td>
    <td class="text-center"> @money($outboundInvoiceItem->getAmountBeforeTaxes()) </td>
    <td class="text-center"> {{ $outboundInvoiceItem->getVatRate()->display_name }} </td>
    <td class="text-right">
        @include('outbound_invoice::item._actions')
    </td>
</tr>