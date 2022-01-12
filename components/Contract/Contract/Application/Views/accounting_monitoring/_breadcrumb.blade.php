@switch($page ?? 'index')
    @case('create')
    @break
    @default
        @breadcrumb_item(__('components.contract.contract.application.views.contract.accounting_monitoring._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract.accounting_monitoring._breadcrumb.contracts')."|href:".route('contract.index'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract.accounting_monitoring._breadcrumb.index')."|active")
@endswitch
