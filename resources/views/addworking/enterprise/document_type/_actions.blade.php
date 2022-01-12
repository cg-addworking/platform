@component('foundation::layout.app._actions')
    @support
        @action_item(__('addworking.enterprise.document_type._actions.add_to_folder')."|icon:folder-plus|href:".folder([])->routes->attach(['enterprise' => $document_type->enterprise])."?id={$document_type->id}")
    @endsupport
    @action_item(__('addworking.enterprise.document_type._actions.consult')."|href:{$document_type->routes->show}|icon:eye")
    @action_item(__('addworking.enterprise.document_type._actions.edit')."|href:{$document_type->routes->edit}|icon:edit")
    @action_item(__('addworking.enterprise.document_type._actions.reject_reason_index')."|href:".route('support.document_type_reject_reason.index', [$document_type->enterprise, $document_type])."|icon:times")
    @action_item(__('addworking.enterprise.document_type._actions.document_type_model')."|href:".route('document_type_model.index', [$document_type->enterprise, $document_type])."|icon:file")
    @action_item(__('addworking.enterprise.document_type._actions.remove')."|href:{$document_type->routes->destroy}|icon:trash|destroy")
@endcomponent
