{{ $contract_party_document_type->contractParty->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|href:{$contract_party_document_type->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|href:{$contract_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_party_document_type}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|href:{$contract_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_party_document_type}|href:{$contract_party_document_type->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.edit')."|active")
        @break
    @case('link')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|href:{$contract_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_party_document_type}|href:{$contract_party_document_type->routes->show}")
        @break
    @case('attach-document')
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.required_document')."|href:{$contract_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_party_document_type}|href:{$contract_party_document_type->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_party_document_type._breadcrumb.attach_document')."|active")
        @break
@endswitch
