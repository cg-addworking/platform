@switch($page)
    @case('choose')
        @breadcrumb_item(__('document::document_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document_model._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.documents')."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item($document_type->display_name."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.choose')."|active")
    @break

    @case('sign')
        @breadcrumb_item(__('document::document_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document_model._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.documents')."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item($document->getDocumentType()->display_name."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.sign')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('document::document_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document::document_model._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.documents')."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item($document->getDocumentType()->display_name."|href:".route('addworking.enterprise.document.index', $enterprise))
        @breadcrumb_item(__('document::document_model._breadcrumb.show')."|active")
    @break
@endswitch
