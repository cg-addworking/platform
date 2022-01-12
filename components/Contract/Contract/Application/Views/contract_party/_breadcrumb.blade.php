@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.index_contract')."|href:".route('contract.index'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.show_contract', ['number' => $contract->getNumber()])."|href:#")
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.create')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
