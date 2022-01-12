@switch($page ?? 'index')
    @case('create')
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.contracts')."|href:".route('contract.index'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.index_accounting_monitoring')."|href:".route('contract_accounting_monitoring.index'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.create')."|active")
    @break
    @default
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.contracts')."|href:".route('contract.index'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.index_accounting_monitoring')."|href:".route('contract_accounting_monitoring.index'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract.capture_invoice._breadcrumb.index')."|active")
@endswitch
