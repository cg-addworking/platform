{{ $contract_template_party->contractTemplate->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.stakeholders')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.stakeholders')."|href:{$contract_template_party->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.stakeholders')."|href:{$contract_template_party->routes->index}")
        @breadcrumb_item("{$contract_template_party}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.stakeholders')."|href:{$contract_template_party->routes->index}")
        @breadcrumb_item("{$contract_template_party}|href:{$contract_template_party->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_template_party._breadcrumb.stakeholders')."|href:{$contract_template_party->routes->index}")
        @breadcrumb_item("{$contract_template_party}|href:{$contract_template_party->routes->show}")
        @break
@endswitch
