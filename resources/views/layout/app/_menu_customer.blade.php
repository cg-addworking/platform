@can('viewAnyVendor', auth()->user()->enterprise)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}">
            @icon('users|mr:2|color:muted') {{ __('layout.app._menu_customer.my_providers') }}
        </a>
    </li>
@endcan
@can('index', sogetrel_passwork())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sogetrel.passwork.index') }}">
            @icon('id-card|mr:2|color:muted') {{ __('layout.app._menu_customer.passwork') }}
        </a>
    </li>
@endcan

@if (auth()->user()->hasAccessToBilling())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('outbound_invoice.index') }}">
            @icon('file-invoice-dollar|mr:2|color:muted') {{ trans_choice('messages.dashboard.invoices', count(Auth::user()->enterprise->outboundInvoices)) }} {{ __('layout.app._menu_customer.addworking') }}
        </a>
    </li>
@endif

@can('index', edenred_code())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('edenred.common.code.index') }}">
            @icon('barcode|mr:2|color:muted') {{ __('layout.app._menu_customer.bussiness_codes') }}
        </a>
    </li>
@endcan

@if(auth()->user()->hasAccessToEnterprise())
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        {{ __('layout.app._menu_customer.enterprise') }}
    </h6>
@endif

<li class="nav-item">
    <a class="nav-link" href="{{ auth()->user()->enterprise->routes->show }}">
        @icon('building|mr:2|color:muted') {{ __('layout.app._menu_customer.my_company') }}
    </a>
</li>

@can('showInvitation', auth()->user()->enterprise)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('addworking.enterprise.invitation.index', ['enterprise' => auth()->user()->enterprise]) }}">
            @icon('paper-plane|mr:2|color:muted') {{ __('layout.app._menu_customer.my_invitations') }}
        </a>
    </li>
@endcan

@if(auth()->user()->hasAccessToMission())
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        {{ __('layout.app._menu_customer.call_for_tender') }}
    </h6>
@endif

@if(subdomain('everial'))
    @can('index', referential())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('everial.mission.referential.index') }}">
                @icon('money-check-alt|mr:2|color:muted') {{ __('layout.app._menu_customer.referential_missions') }}
            </a>
        </li>
    @endcan
@endif

@can('index', mission_offer())
    <li class="nav-item">
        <a class="nav-link" href="{{ subdomain('everial') ? route('everial.mission-offer.index') : route(subdomain('edenred') ? 'edenred.mission-offer.index' : 'mission.offer.index') }}">
            @icon('bullhorn|mr:2|color:muted') {{ __('layout.app._menu_customer.mission_offers') }}
        </a>
    </li>
@endcan

@can('index', mission_proposal())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.proposal.index') }}">
            @icon('gift|mr:2|color:muted') {{ __('layout.app._menu_customer.mission_proposal') }}
        </a>
    </li>
@endcan

@can('index', mission())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.index') }}">
            @icon('handshake|mr:2|color:muted') {{ __('layout.app._menu_customer.missions') }}
        </a>
    </li>
@endcan

@can('index', [purchase_order(), auth()->user()->enterprise])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('enterprise.purchase_order.index', Auth::user()->enterprise) }}">
            @icon('file-invoice|mr:2|color:muted') {{ __('layout.app._menu_customer.purchase_orders') }}
        </a>
    </li>
@endcan

@can('index', mission_tracking())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.tracking.index') }}">
            @icon('chart-bar|mr:2|color:muted') {{ __('layout.app._menu_customer.mission_monitoring') }}
        </a>
    </li>
@endcan