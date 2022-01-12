{{ $mission_tracking->mission->views->breadcrumb(['page' => "link"]) }}

@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.index')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.index')."|href:{$mission_tracking->routes->show}#nav-index-tab")
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.index')."|href:{$mission_tracking->routes->show}#nav-index-tab")
        @breadcrumb_item("{$mission_tracking}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.index')."|href:{$mission_tracking->routes->show}")
        @breadcrumb_item("{$mission_tracking}|href:{$mission_tracking->routes->show}")
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.mission.mission_tracking._breadcrumb.index')."|href:{$mission_tracking->routes->show}")
        @breadcrumb_item("{$mission_tracking}|href:{$mission_tracking->routes->show}")
        @break
@endswitch
