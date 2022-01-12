@component('foundation::layout.app._actions', ['model' => $invoiceParameter])
    @can('show', [get_class($invoiceParameter), $invoiceParameter])
        <a class="dropdown-item" href="{{ route('addworking.enterprise.parameter.show', [$enterprise, $invoiceParameter]) }}">
            @icon('eye|mr:3|color:muted') {{ __('enterprise.invoiceParameter.application.views._actions.consult') }}
        </a>
    @endcan

    @can('edit', [get_class($invoiceParameter), $invoiceParameter])
        <a class="dropdown-item" href="{{ route('addworking.enterprise.parameter.edit', [$enterprise, $invoiceParameter]) }}">
            @icon('edit|mr:3|color:muted') {{ __('enterprise.invoiceParameter.application.views._actions.edit') }}
        </a>
    @endcan
@endcomponent