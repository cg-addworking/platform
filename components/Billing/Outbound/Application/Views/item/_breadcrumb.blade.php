@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.invoice_lines')."|href:".route('addworking.billing.outbound.item.index', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.create')."|active")
        @break

    @default
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views.item._breadcrumb.invoice_lines')."|active")
@endswitch
