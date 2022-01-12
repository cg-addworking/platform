{{ $contract_template->enterprise->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.contract_templates')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.contract_templates')."|href:{$contract_template->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.contract_templates')."|href:{$contract_template->routes->index}")
        @breadcrumb_item("{$contract_template}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.contract_templates')."|href:{$contract_template->routes->index}")
        @breadcrumb_item("{$contract_template}|href:{$contract_template->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_template._breadcrumb.contract_templates')."|href:{$contract_template->routes->index}")
        @breadcrumb_item("{$contract_template}|href:{$contract_template->routes->show}")
        @break
@endswitch
