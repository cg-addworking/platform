@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_commission')."|active")
    @break

    @case('create')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_commission')."|href:".route('addworking.billing.outbound.fee.index', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.calculate_commissions')."|active")
    @break

    @case('indexCreditFees')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_commission')."|active")
    @break

    @default
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|active")
@endswitch
