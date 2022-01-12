@component('foundation::layout.app._actions', ['model' => $inbound_invoice])
    @can('download', $inbound_invoice)
        <a class="dropdown-item" href="{{ $inbound_invoice->file->routes->download }}">
            @icon('download|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._action.download') }}
        </a>
    @endif

    @can('index', $inbound_invoice->items)
        <a class="dropdown-item" href="{{ $inbound_invoice->items->routes->index }}">
            @icon('download|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._action.items') }}
        </a>
    @endif

    @can('index', [inbound_invoice_item(), $inbound_invoice])
        <a class="dropdown-item" href="{{ inbound_invoice_item([])->routes->index(@compact('enterprise', 'inbound_invoice')) }}">
            @icon('sitemap|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._action.reconciliation') }}
        </a>
    @endif
@endcomponent
