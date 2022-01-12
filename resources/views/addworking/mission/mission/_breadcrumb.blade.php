{{ $mission->customer->views->breadcrumb(['page' => "link"]) }}

@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.index')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.index')."|href:{$mission->routes->show}#nav-index-tab")
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.index')."|href:{$mission->routes->show}#nav-index-tab")
        @breadcrumb_item("{$mission}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.index')."|href:{$mission->routes->show}")
        @breadcrumb_item("{$mission}|href:{$mission->routes->show}")
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.mission.mission._breadcrumb.index')."|href:{$mission->routes->show}")
        @breadcrumb_item("{$mission}|href:{$mission->routes->show}")
        @break
@endswitch
