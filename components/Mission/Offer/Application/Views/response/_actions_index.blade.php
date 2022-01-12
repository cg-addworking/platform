@component('foundation::layout.app._actions')
    <a class="dropdown-item" href="{{ route('sector.response.show', [$offer, $response]) }}">
        @icon('eye|mr:3|color:muted') {{ __('offer::response._actions.show') }}
    </a>
@endcomponent