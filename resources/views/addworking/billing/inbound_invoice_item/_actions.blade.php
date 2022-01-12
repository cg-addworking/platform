@component('foundation::layout.app._actions')
    @action_item(__('addworking.billing.inbound_invoice_item._actions.consult') ."|href:{$inbound_invoice_item->routes->show([$inbound_invoice_item->invoice->enterprise, $inbound_invoice_item->invoice])}|icon:eye")
    @action_item(__('addworking.billing.inbound_invoice_item._actions.edit') ."|href:{$inbound_invoice_item->routes->edit([$inbound_invoice_item->invoice->enterprise, $inbound_invoice_item->invoice])}|icon:edit")
    @if ($inbound_invoice_item->invoiceable)
        <a class="dropdown-item text-danger" href="#" onclick="confirm('Confirmer la dissociation ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('unlink|mr:3') {{ __('addworking.billing.inbound_invoice_item._actions.dissociate') }}
        </a>
        @push('modals')
            <form name="{{ $name }}" action="{{ $inbound_invoice_item->routes->destroy([$inbound_invoice_item->invoice->enterprise, $inbound_invoice_item->invoice]) }}" method="post">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @else
        @action_item(__('addworking.billing.inbound_invoice_item._actions.remove') ."|href:{$inbound_invoice_item->routes->destroy([$inbound_invoice_item->invoice->enterprise, $inbound_invoice_item->invoice])}|icon:trash|destroy")
    @endif
@endcomponent
