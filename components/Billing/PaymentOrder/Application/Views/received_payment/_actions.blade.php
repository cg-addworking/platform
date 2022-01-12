@component('foundation::layout.app._actions', ['model' => $received_payment])
    @can('edit', $received_payment)
        <a class="dropdown-item" href="{{ route('addworking.billing.received_payment.edit', [$received_payment->enterprise, $received_payment]) }}">
            @icon('edit|mr:3|color:muted') {{ __('addworking.components.billing.outbound.received_payment._actions.edit') }}
        </a>
    @endcan

    @can('delete', $received_payment)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('addworking.components.billing.outbound.received_payment._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('addworking.billing.received_payment.delete', [$received_payment->enterprise, $received_payment]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
