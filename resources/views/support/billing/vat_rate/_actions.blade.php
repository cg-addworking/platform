@component('foundation::layout.app._actions')
    @action_item("Consulter|href:{$vat_rate->routes->show}|icon:eye")
    @action_item("Modifier|href:{$vat_rate->routes->edit}|icon:edit")
    @action_item("Supprimer|href:{$vat_rate->routes->destroy}|icon:trash|destroy")
@endcomponent
