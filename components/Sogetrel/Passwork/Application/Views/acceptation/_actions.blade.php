@component('foundation::layout.app._actions')
    @can('show', $acceptation->getSogetrelPasswork())
        <a class="dropdown-item" href="{{ route('sogetrel.passwork.show', $acceptation->getSogetrelPasswork()) }}">
            @icon('eye|mr:3|color:muted') {{ __('sogetrel_passwork::acceptation._actions.passwork') }}
        </a>
    @endcan

    <a class="dropdown-item" target=_blank href="{{ route('sogetrel.passwork.acceptation.optional_monitoring_data', [$acceptation->getSogetrelPasswork(), $acceptation]) }}">
        @icon('eye|mr:3|color:muted') {{ __('sogetrel_passwork::acceptation._actions.operational_monitoring_data') }}
    </a>

@endcomponent
