@component('bootstrap::dropdown', ['text' => "Actions", 'outline' => true, 'class' => 'btn-sm'])
    @can('view', $inbound_invoice)
        <a class="dropdown-item" href="{{ $inbound_invoice->routes->show }}">
            @icon('eye|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._dropdown.consulter') }}
        </a>
    @endcan

    @can('download', $inbound_invoice)
        <a class="dropdown-item" href="{{ $inbound_invoice->file->routes->download }}">
            @icon('download|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._dropdown.download') }}
        </a>
    @endif

    @can('update', $inbound_invoice)
        <a class="dropdown-item" href="{{ $inbound_invoice->routes->edit }}">
            @icon('edit|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._dropdown.modifier') }}
        </a>
    @endcan

    @can('index', [inbound_invoice_item(), $inbound_invoice])
        <a class="dropdown-item" href="{{ inbound_invoice_item([])->routes->index(@compact('enterprise', 'inbound_invoice')) }}">
            @icon('sitemap|mr:3|color:muted') {{ __('addworking.billing.inbound_invoice._dropdown.invoice_lines') }}
        </a>
    @endif

    @can('delete', $inbound_invoice)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger">{{ __('addworking.billing.inbound_invoice._dropdown.remove') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ $inbound_invoice->routes->destroy }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
