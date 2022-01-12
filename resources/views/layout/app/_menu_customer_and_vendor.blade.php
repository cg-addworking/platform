<li class="nav-item">
    <a class="nav-link" href="{{ route('profile.customers') }}">
        @icon('users|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_clients') }}
    </a>
</li>

@can('viewAnyVendor', auth()->user()->enterprise)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}">
            @icon('users|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_providers') }}
        </a>
    </li>
@endcan

@if (auth()->user()->hasAccessToBilling())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('outbound_invoice.index') }}">
            @icon('file-invoice-dollar|mr:2|color:muted') {{ trans_choice('messages.dashboard.invoices', count(Auth::user()->enterprise->outboundInvoices)) }} {{ __('layout.app._menu_customer_and_vendor.addworking') }}
        </a>
    </li>
@endif

@can('index', [inbound_invoice(), Auth::user()->enterprise])
    <li class="nav-item">
        <a class="nav-link" href="{{ inbound_invoice([])->enterprise()->associate(Auth::user()->enterprise)->routes->index }}">
            @icon('file-invoice-dollar|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_bills') }}
        </a>
    </li>
@endcan

@can('index', sogetrel_passwork())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sogetrel.passwork.index') }}">
            @icon('id-card|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.passwork') }}
        </a>
    </li>
@endcan

@can('index', edenred_code())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('edenred.common.code.index') }}">
            @icon('barcode|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.bussiness_codes') }}
        </a>
    </li>
@endcan

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    {{ __('layout.app._menu_customer_and_vendor.enterprise') }}
</h6>

<li class="nav-item">
    <a class="nav-link" href="{{ auth()->user()->enterprise->routes->show }}">
        @icon('building|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_company') }}
    </a>
</li>

@can('showInvitation', auth()->user()->enterprise)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('addworking.enterprise.invitation.index', ['enterprise' => auth()->user()->enterprise]) }}">
            @icon('paper-plane|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_invitations') }}
        </a>
    </li>
@endcan

@can('showIndexMenu', [document(), auth()->user()->enterprise])
    <li class="nav-item">
        <a class="nav-link" href="{{ document([])->enterprise()->associate(auth()->user()->enterprise)->routes->index }}">
            @icon('file|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_certificates') }}
        </a>
    </li>
@endcan

@can('create', iban())
    @if (auth()->user()->enterprise->iban->exists)
        <li class="nav-item">
            <a class="nav-link" href="{{ auth()->user()->enterprise->iban->routes->show }}">
                @icon('money-check|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_iban') }}
            </a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ iban([])->enterprise()->associate(auth()->user()->enterprise)->routes->create }}">
                @icon('money-check|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_iban') }}
            </a>
        </li>
    @endif
@endcan

@if(auth()->user()->sogetrelPasswork->exists)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sogetrel.passwork.show', auth()->user()->sogetrelPasswork) }}">
            @icon('id-card|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_passwork') }}
        </a>
    </li>
@else
    @can('index', [passwork(), auth()->user()->enterprise])
        <li class="nav-item">
            <a class="nav-link" href="{{ route('addworking.common.enterprise.passwork.index', auth()->user()->enterprise) }}">
                @icon('id-card|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.my_passwork') }}
            </a>
        </li>
    @endcan
@endif

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    {{ __('layout.app._menu_customer_and_vendor.call_for_tender') }}
</h6>

@can('index', mission_offer())
    <li class="nav-item">
        <a class="nav-link" href="{{ subdomain('everial') ? route('everial.mission-offer.index') : route(subdomain('edenred') ? 'edenred.mission-offer.index' : 'mission.offer.index') }}">
            @icon('bullhorn|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.mission_offers') }}
        </a>
    </li>
@endcan

@can('index', mission_proposal())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.proposal.index') }}">
            @icon('gift|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.mission_proposal') }}
        </a>
    </li>
@endcan

@can('index', mission())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.index') }}">
            @icon('handshake|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.mission') }}
        </a>
    </li>
@endcan

@can('index', [purchase_order(), auth()->user()->enterprise])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('enterprise.purchase_order.index', Auth::user()->enterprise) }}">
            @icon('file-invoice|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.purchase_orders') }}
        </a>
    </li>
@endcan

@can('index', mission_tracking())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.tracking.index') }}">
            @icon('chart-bar|mr:2|color:muted') {{ __('layout.app._menu_customer_and_vendor.mission_monitoring') }}
        </a>
    </li>
@endcan