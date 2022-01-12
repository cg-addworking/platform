@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party_document._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party_document._breadcrumb.index_contract')."|href:".route('contract.index'))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party_document._breadcrumb.show_contract', ['number' => $contract_party->getContract()->getNumber()])."|href:".route('contract.show', $contract_party->getContract() ))
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party_document._breadcrumb.index', ['enterprise_name' => $contract_party->getEnterpriseName()])."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.contract.application.views.contract_party._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
