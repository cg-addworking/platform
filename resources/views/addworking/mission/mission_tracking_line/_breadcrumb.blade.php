{{ $mission_tracking_line->missionTracking->views->breadcrumb(['page' => "link"]) }}

@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.index')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.index')."|href:{$mission_tracking_line->routes->index}#nav-index-tab")
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.index')."|href:{$mission_tracking_line->routes->index}#nav-index-tab")
        @breadcrumb_item("{$mission_tracking_line}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.index')."|href:{$mission_tracking_line->routes->index}")
        @breadcrumb_item("{$mission_tracking_line}|href:{$mission_tracking_line->routes->show}")
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.mission.mission_tracking_line._breadcrumb.index')."|href:{$mission_tracking_line->routes->index}")
        @breadcrumb_item("{$mission_tracking_line}|href:{$mission_tracking_line->routes->show}")
        @break
@endswitch
