<tr>
    <td>{{ $payment_order->getNumber() }}</td>
    <td>@date($payment_order->created_at)</td>
    <td>@date($payment_order->getExecutedAt())</td>
    <td class="text-center">
        @include('payment_order::payment_order._status')
    </td>
    <td class="text-right">
        @include('payment_order::payment_order._actions')
    </td>

</tr>