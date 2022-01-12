{{ $contract_template_variable->contractTemplate->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case("index")
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.variables')."|active")
        @break
    @case("create")
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.variables')."|href:{$contract_template_variable->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.variables')."|href:{$contract_template_variable->routes->index}")
        @breadcrumb_item("{$contract_template_variable}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.variables')."|href:{$contract_template_variable->routes->index}")
        @breadcrumb_item("{$contract_template_variable}|href:{$contract_template_variable->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_template_variable._breadcrumb.variables')."|href:{$contract_template_variable->routes->index}")
        @breadcrumb_item("{$contract_template_variable}|href:{$contract_template_variable->routes->show}")
        @break
@endswitch
