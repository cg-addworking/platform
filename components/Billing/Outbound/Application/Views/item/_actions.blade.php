@component('foundation::layout.app._actions', ['model' => $outboundInvoiceItem])
    @can('delete', $outboundInvoiceItem)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('billing.outbound.application.views.item._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.item.delete', [$enterprise, $outboundInvoice, $outboundInvoiceItem]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent