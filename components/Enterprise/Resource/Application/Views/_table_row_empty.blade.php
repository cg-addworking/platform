@component('layout.app._table_row_empty')
    {{ __('enterprise.resource.application.views._table_row_empty.text_1') }} {{ $resource->enterprise->views->link }} {{ __('enterprise.resource.application.views._table_row_empty.text_2') }}

    @slot('create')
        @can('create', [get_class($resource), $resource->enterprise])
            @component('bootstrap::button', ['href' => $resource->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('enterprise.resource.application.views._table_row_empty.add_resource') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
