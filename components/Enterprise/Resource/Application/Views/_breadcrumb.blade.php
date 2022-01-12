{{ $resource->enterprise->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resource_number')." {$resource->getNumber()}|active")
        @break
    @case('link')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resource_number')." {$resource->getNumber()}|href:{$resource->routes->show}")
        @break
    @case('edit')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resource_number')." {$resource->getNumber()}|href:{$resource->routes->show}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.edit')."|active")
        @break
    @case('assign')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resource_number')." {$resource->getNumber()}|href:{$resource->routes->show}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.assign')."|active")
        @break
    @case('attach')
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|href:{$resource->routes->index}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resource_number')." {$resource->getNumber()}|href:{$resource->routes->show}")
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.add')."|active")
    @break
    @default
        @breadcrumb_item(__('enterprise.resource.application.views._breadcrumb.resources')."|active")
@endswitch
