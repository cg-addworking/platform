@switch($page ?? 'index')

    @case('edit')
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.index_contract')."|href:".route('contract.index'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.show_contract', ['number' => $contract->getNumber()])."|href:".route('contract.show', $contract))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.define_value')."|active")
    @break

    @case('index')
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.index_contract')."|href:".route('contract.index'))
    @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.show_contract', ['number' => $contract->getNumber()])."|href:".route('contract.show', $contract))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_variable._breadcrumb.index')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.dashboard')."|href:".route('dashboard'))

@endswitch
