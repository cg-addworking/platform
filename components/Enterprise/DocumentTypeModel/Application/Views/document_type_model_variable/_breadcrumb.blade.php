@breadcrumb_item(__('document_type_model::document_type_model_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
@breadcrumb_item(__('document_type_model::document_type_model_variable._breadcrumb.document_type_management').'|href:'.route('addworking.enterprise.document-type.index', $enterprise))
@breadcrumb_item($document_type->display_name.'|href:'.route('addworking.enterprise.document-type.show', [$enterprise, $document_type]))
@breadcrumb_item(__('document_type_model::document_type_model_variable._breadcrumb.index').'|href:'.route('document_type_model.index', [$enterprise, $document_type]))
@breadcrumb_item($document_type_model->display_name.'|href=#')
@breadcrumb_item(__('document_type_model::document_type_model_variable._breadcrumb.edit_variable')."|active")