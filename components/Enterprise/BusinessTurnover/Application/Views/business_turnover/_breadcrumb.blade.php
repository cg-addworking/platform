@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('business_turnover::business_turnover._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('business_turnover::business_turnover._breadcrumb.index')."|active")
        @breadcrumb_item(__('business_turnover::business_turnover._breadcrumb.create')."|active")
    @break

    @default
        @breadcrumb_item(__('business_turnover::business_turnover._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('business_turnover::business_turnover._breadcrumb.index')."|active")
@endswitch
