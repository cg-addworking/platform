@component('foundation::layout.app._actions', ['model' => $resource])
    @can('assign', $resource)
        <a class="dropdown-item" href="{{ $resource->routes->assign }}">
            @icon('link|mr:3|color:muted') {{ __('enterprise.resource.application.views._actions.assign') }}
        </a>
    @endif
@endcomponent
