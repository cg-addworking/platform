@component('foundation::layout.app._actions', ['model' => $activity_period])
    @can('show', $activity_period)
        <a class="dropdown-item" href="{{ $activity_period->resource->routes->show }}">
            @icon('eye|mr:3|color:muted') {{ __('enterprise.resource.application.views.activity_period._actions.consult') }}
        </a>
    @endif
@endcomponent
