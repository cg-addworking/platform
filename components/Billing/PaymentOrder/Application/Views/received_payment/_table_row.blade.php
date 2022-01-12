<tr>
    <td class="text-center">
        {{ $received_payment->getNumber() }}
    </td>
    <td>{{ $received_payment->getBankReferencePayment() }}</td>
    <td>
        @forelse($receivedPaymentRepository->getOutboundInvoices($received_payment) as $outbound_invoice)
            <a href="{{ route('addworking.billing.outbound.show', [$outbound_invoice->enterprise, $outbound_invoice]) }}" target="_blank">{{ $outbound_invoice->getFormattedNumber() }}</a>
            @if (! $loop->last)
                /
            @endif
        @empty
            n/a
        @endforelse
    </td>
    <td class="text-center">
        @date($received_payment->getReceivedAt())
    </td>
    <td>{{ $received_payment->getIbanReference() }}</td>
    <td>{{ $received_payment->getBicReference() }}</td>
    <td class="text-right">
        @money($received_payment->getAmount())
    </td>
    <td class="text-right">
        @include('payment_order::received_payment._actions')
    </td>
</tr>
