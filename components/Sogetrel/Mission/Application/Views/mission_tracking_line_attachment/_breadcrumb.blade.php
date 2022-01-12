@breadcrumb_item(__('brands.sogetrel'))

@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.index')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.index')."|href:{$mission_tracking_line_attachment->routes->index}")
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.index')."|href:{$mission_tracking_line_attachment->routes->index}")
        @breadcrumb_item("{$mission_tracking_line_attachment}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.index')."|href:{$mission_tracking_line_attachment->routes->index}")
        @breadcrumb_item("{$mission_tracking_line_attachment}|href:{$mission_tracking_line_attachment->routes->show}")
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment._breadcrumb.index')."|href:{$mission_tracking_line_attachment->routes->index}")
        @breadcrumb_item("{$mission_tracking_line_attachment}|href:{$mission_tracking_line_attachment->routes->show}")
        @break
@endswitch
