@breadcrumb_item(__('addworking.enterprise.enterprise._breadcrumb.dashboard')."|href:".route('dashboard'))
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.enterprise.enterprise._breadcrumb.enterprise')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.enterprise.enterprise._breadcrumb.enterprise')."|href:{$enterprise->routes->index}")
        @breadcrumb_item("{$enterprise}|show")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.enterprise.enterprise._breadcrumb.enterprise')."|href:{$enterprise->routes->index}")
        @breadcrumb_item("{$enterprise}|href:{$enterprise->routes->show}")
        @break
@endswitch
