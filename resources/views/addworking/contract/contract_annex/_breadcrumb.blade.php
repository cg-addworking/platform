{{ $contract_annex->contract->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.annexes')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.annexes')."|href:{$contract_annex->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.annexes')."|href:{$contract_annex->routes->index}")
        @breadcrumb_item("{$contract_annex}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.annexes')."|href:{$contract_annex->routes->index}")
        @breadcrumb_item("{$contract_annex}|href:{$contract_annex->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_annex._breadcrumb.annexes')."|href:{$contract_annex->routes->index}")
        @breadcrumb_item("{$contract_annex}|href:{$contract_annex->routes->show}")
        @break
@endswitch
