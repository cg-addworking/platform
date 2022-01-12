{{ $contract_party->contract->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.stakeholders')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.stakeholders')."|href:{$contract_party->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.stakeholders')."|href:{$contract_party->routes->index}")
        @breadcrumb_item("{$contract_party}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.stakeholders')."|href:{$contract_party->routes->index}")
        @breadcrumb_item("{$contract_party}|href:{$contract_party->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_party._breadcrumb.stakeholders')."|href:{$contract_party->routes->index}")
        @breadcrumb_item("{$contract_party}|href:{$contract_party->routes->show}")
        @break
@endswitch
