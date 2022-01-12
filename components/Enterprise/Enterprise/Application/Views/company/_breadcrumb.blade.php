@switch($page ?? 'index')
    @case('show')
        @breadcrumb_item(__('company::company._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('company::company._breadcrumb.index')."|href:".route('company.index'))
        @breadcrumb_item(__('company::company._breadcrumb.show', ["short_id" => $company->getShortId()])."|active")
    @break
    @default
        @breadcrumb_item(__('company::company._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('company::company._breadcrumb.index')."|active")
@endswitch
