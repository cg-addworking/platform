@component('foundation::layout.app._actions', ['model' => $payment_order])
    @can('dissociate', $payment_order)
        <a class="dropdown-item" href="{{ route('addworking.billing.payment_order.index_dissociate', [$enterprise, $payment_order]) }}">
            @icon('file-invoice|mr:3|color:muted') {{ __('addworking.components.billing.outbound.payment_order._actions.associated_invoices') }}
        </a>
    @endcan
    @can('generate', $payment_order)
        <a class="dropdown-item" href="{{ route('addworking.billing.payment_order.generate', [$enterprise, $payment_order]) }}">
            @icon('file-alt|mr:3|color:muted') Générer
        </a>
    @endcan
@endcomponent