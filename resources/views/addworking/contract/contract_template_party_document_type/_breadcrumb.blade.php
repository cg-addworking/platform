{{ $contract_template_party_document_type->contractTemplateParty->views->breadcrumb(['page' => "link"]) }}
@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.documents_to_provide')."|active")
        @break
    @case('create')
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.documents_to_provide')."|href:{$contract_template_party_document_type->routes->index}")
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.create')."|active")
        @break
    @case('show')
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.documents_to_provide')."|href:{$contract_template_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_template_party_document_type}|active")
        @break
    @case('edit')
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.documents_to_provide')."|href:{$contract_template_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_template_party_document_type}|href:{$contract_template_party_document_type->routes->show}")
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.edit')."|active")
        @break
    @case('title')
        @breadcrumb_item(__('addworking.contract.contract_template_party_document_type._breadcrumb.documents_to_provide')."|href:{$contract_template_party_document_type->routes->index}")
        @breadcrumb_item("{$contract_template_party_document_type}|href:{$contract_template_party_document_type->routes->show}")
        @break
@endswitch
