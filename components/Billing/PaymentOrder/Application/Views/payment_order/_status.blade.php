@switch($payment_order->getStatus())
    @case('pending')
        <span class="badge badge-pill badge-primary">En attente</span>
        @break

    @case('executed')
        <span class="badge badge-pill badge-success">Exécuté</span>
        @break

    @default
        <span class="badge badge-pill badge-primary">{{ $payment_order->getStatus() }}</span>
        @break
@endswitch