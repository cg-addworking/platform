@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.index').'|href:'.route('document_type_model.index', [$enterprise, $document_type]))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.index').'|href:'.route('document_type_model.index', [$enterprise, $document_type]))
        @breadcrumb_item($document_type_model->display_name.'|href=#')
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.edit')."|active")
    @break

    @case('show')
    @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
    @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
    @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.index').'|href:'.route('document_type_model.index', [$enterprise, $document_type]))
    @breadcrumb_item($document_type_model->getDisplayName()."|active")
    @break

    @default
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
        @breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
        @breadcrumb_item(__('document_type_model::document_type_model._breadcrumb.index')."|active")
    @break
@endswitch
