@component('foundation::layout.app._actions')
    @action_item("Consulter|href:{$deadline_type->routes->show}|icon:eye")
    @action_item("Modifier|href:{$deadline_type->routes->edit}|icon:edit")
    @action_item("Supprimer|href:{$deadline_type->routes->destroy}|icon:trash|destroy")
@endcomponent
