@component('layout.app._table_row_empty')
    {{ __('addworking.mission.mission_tracking_line._table_row_empty.the_tracking') }} {{
    $mission_tracking_line->missionTracking }} {{ __('addworking.mission.mission_tracking_line._table_row_empty.doesnt_have_lines') }}

    @slot('create')
        @can('create', [get_class($mission_tracking_line), $mission_tracking_line->missionTracking])
            @component('bootstrap::button', ['href' => $mission_tracking_line->routes->create, 'icon' => "plus", 'color' => "success"])
                {{ __('addworking.mission.mission_tracking_line._table_row_empty.add_line') }}
            @endcomponent
        @endcan
    @endslot
@endcomponent
