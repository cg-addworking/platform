@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.index')."|href:".route('support.document_type_reject_reason.index', [$enterprise, $document_type]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.index')."|href:".route('support.document_type_reject_reason.index', [$enterprise, $document_type]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.number', ['number' => $document_type_reject_reason->getNumber()])."|href:".route('support.document_type_reject_reason.edit', [$enterprise, $document_type, $document_type_reject_reason]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.edit')."|active")
    @break

    @default
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document::document.document_type_reject_reason._breadcrumb.index')."|active")
    @break
@endswitch
