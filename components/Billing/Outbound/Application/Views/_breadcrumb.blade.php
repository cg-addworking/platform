@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.create')."|active")
        @break

    @case('show')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|active")
        @break

    @case('associate')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.provider_invoice')."|active")
    @break

    @case('generateFile')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.generate_file')."|active")
        @break

    @case('indexCreditLine')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.create_credit_lines')."|active")
        @break

    @case('edit')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.invoice_number')." {$outboundInvoice->getNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice]))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.edit')."|active")
    @break

    @case('link')
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|href:".route('addworking.billing.outbound.index', $enterprise))
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.number')." {$outbound_invoice->getFormattedNumber()}|href:".route('addworking.billing.outbound.show', [$enterprise, $outbound_invoice]))
    @break

    @default
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('billing.outbound.application.views._breadcrumb.addworking_invoices')."|active")
@endswitch
