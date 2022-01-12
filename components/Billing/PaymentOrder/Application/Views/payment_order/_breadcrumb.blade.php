@breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
@breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")

@switch($page)
    @case('create')
        @breadcrumb_item("Ordres de paiements|href:".route('addworking.billing.payment_order.index', $enterprise))
        @breadcrumb_item("Créer|active")
    @break

    @case('edit')
        @breadcrumb_item("Ordres de paiements|href:".route('addworking.billing.payment_order.index', $enterprise))
        @breadcrumb_item("N° {$payment_order->getNumber()}|href:".route('addworking.billing.payment_order.show', [$enterprise, $payment_order]))
        @breadcrumb_item("Modifier|active")
    @break

    @case('associate')
        @breadcrumb_item("Ordres de paiements|href:".route('addworking.billing.payment_order.index', $enterprise))
        @breadcrumb_item("N° {$payment_order->getNumber()}|href:".route('addworking.billing.payment_order.show', [$enterprise, $payment_order]))
        @breadcrumb_item("Factures prestataires - reste a payer|active")
    @break

    @case('dissociate')
        @breadcrumb_item("Ordres de paiements|href:".route('addworking.billing.payment_order.index', $enterprise))
        @breadcrumb_item("N° {$payment_order->getNumber()}|href:".route('addworking.billing.payment_order.show', [$enterprise, $payment_order]))
        @breadcrumb_item("Factures prestataires incluses|active")
    @break

    @case('index')
        @breadcrumb_item("Ordres de paiements|active")
    @break

    @case('show')
        @breadcrumb_item("Ordres de paiements|href:" . $payment_order->routes->index)
        @breadcrumb_item("Ordre de paiement n°{$payment_order->getNumber()}|active")
    @break
@endswitch
