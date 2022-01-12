@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.invoice_parameter')."|active")
        @break

    @case('show')
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.invoice_parameter')."|href:".route('addworking.enterprise.parameter.index', $enterprise))
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.parameter_number').substr($invoiceParameter->getId(), 0, 8)."|active")
        @break

    @case('create')
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.invoice_parameter')."|href:".route('addworking.enterprise.parameter.index', $enterprise))
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.create')."|href:".route('addworking.enterprise.parameter.create', $enterprise))
        @break

    @case('edit')
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.invoice_parameter')."|href:".route('addworking.enterprise.parameter.index', $enterprise))
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.number', ['number' => $invoice_parameter->getNumber()])."|href:".route('addworking.enterprise.parameter.show', [$enterprise, $invoice_parameter]))
        @breadcrumb_item(__('enterprise.invoiceParameter.application.views._breadcrumb.edit')."|active")
    @break
@endswitch
