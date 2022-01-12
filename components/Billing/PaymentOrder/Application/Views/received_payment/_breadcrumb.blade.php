@breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))

@switch($page)
    @case('index')
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item("Paiements reçus|active")
    @break
    @case('support_index')
        @breadcrumb_item("Paiements reçus|active")
    @break
    @case('create')
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item("Paiements reçus|href:".route('addworking.billing.received_payment.index', $enterprise))
        @breadcrumb_item("Créer|active")
    @break
    @case('edit')
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item("Paiements reçus|href:".route('addworking.billing.received_payment.index', $enterprise))
        @breadcrumb_item("Paiement reçu n°".$received_payment->getNumber()."|href:#")
        @breadcrumb_item("Modifier|active")
    @break
@endswitch
