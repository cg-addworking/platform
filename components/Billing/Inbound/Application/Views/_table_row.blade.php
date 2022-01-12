<tr>
      <td>
            <a href="{{ route('enterprise.show', $invoice->enterprise)}}">{{ $invoice->enterprise->name }}</a><br>
            <a href="{{ route('enterprise.show', $invoice->customer)}}">{{ $invoice->customer->name }}</a>
      </td>
      <td>
            @if($invoice->outboundInvoice->exists)
                  <a href="{{ route('addworking.billing.outbound.show', ['enterprise' => $invoice->outboundInvoice->getEnterprise(), 'outbound_invoice' => $invoice->outboundInvoice]) }}" target="_blank">
                        {{ $invoice->outboundInvoice->getFormattedNumber() }}
                  </a>
            @else
                  n/a
            @endif
      </td>
      <td>{{ $invoice->month }}</td>
      <td>@date($invoice->due_at)</td>
      <td>@include('inbound::_status')</td>
      <td>@money($invoice->amount_before_taxes)</td>
      <td>@money($invoice->amount_of_taxes)</td>
      <td>@money($invoice->amount_all_taxes_included)</td>
      <td class="text-right">{{ $invoice->views->actions }}</td>
</tr>