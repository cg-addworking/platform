{{ $contract_document->contract->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.documents')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.documents')."|href:{$contract_document->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.documents')."|href:{$contract_document->routes->index}")
        @breadcrumb_item("{$contract_document}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.documents')."|href:{$contract_document->routes->index}")
        @breadcrumb_item("{$contract_document}|href:{$contract_document->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_document._breadcrumb.documents')."|href:{$contract_document->routes->index}")
        @breadcrumb_item("{$contract_document}|href:{$contract_document->routes->show}")
        @break
@endswitch
