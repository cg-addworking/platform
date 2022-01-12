<a class="list-group-item list-group-item-action bg-light " href="{{ route('dashboard') }}">
    @icon('home|mr:2') {{ trans('foundation::menu_customer.dashboard') }}
</a>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('profile.customers') }}">
    @icon('users|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_customers') }}
</a>

@can('index', [inbound_invoice(), Auth::user()->enterprise])
    <a class="list-group-item list-group-item-action bg-light" href="{{ inbound_invoice([])->enterprise()->associate(Auth::user()->enterprise)->routes->index }}">
        @icon('file-invoice-dollar|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_invoices') }}
    </a>
@endcan

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_vendor.enterprise') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ auth()->user()->enterprise->routes->show }}">
    @icon('building|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_enterprise') }}
</a>

@can('showInvitation', auth()->user()->enterprise)
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('addworking.enterprise.invitation.index', ['enterprise' => auth()->user()->enterprise]) }}">
        @icon('paper-plane|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_invitations') }}
    </a>
@endcan

@can('create', iban())
    @if (auth()->user()->enterprise->iban->exists)
        <a class="list-group-item list-group-item-action bg-light" href="{{ auth()->user()->enterprise->iban->routes->show }}">
            @icon('money-check|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_iban') }}
        </a>
    @else
        <a class="list-group-item list-group-item-action bg-light" href="{{ iban([])->enterprise()->associate(auth()->user()->enterprise)->routes->create }}">
            @icon('money-check|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_iban') }}
        </a>
    @endif
@endcan

@if(auth()->user()->sogetrelPasswork->exists)
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('sogetrel.passwork.show', auth()->user()->sogetrelPasswork) }}">
        @icon('id-card|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_passwork') }}
    </a>
@endcan

@can('index', [passwork(), auth()->user()->enterprise])
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('addworking.common.enterprise.passwork.index', auth()->user()->enterprise) }}">
        @icon('id-card|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_passworks') }}
    </a>
@endcan

@can('showIndexMenu', [document(), auth()->user()->enterprise])
    <a class="list-group-item list-group-item-action bg-light" href="{{ document([])->enterprise()->associate(auth()->user()->enterprise)->routes->index }}">
        @icon('file|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_documents') }}
    </a>
@endcan

@if(auth()->user()->hasAccessToContract())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('contract.index') }}">
        @icon('file-signature|mr:2|color:muted') {{ trans('foundation::menu_vendor.my_contracts') }}
    </a>
@endif

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_vendor.offers') }}
</h6>

@if ($sectorRepository->hasCustomerInConstructionSector(auth()->user()->enterprise))
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('sector.offer.index')}}">
        @icon('gift|mr:2|color:muted') {{ trans('foundation::menu_vendor.mission_proposals') }}
    </a>
@else
    @can('index', mission_proposal())
        <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.proposal.index') }}">
            @icon('gift|mr:2|color:muted') {{ trans('foundation::menu_vendor.mission_proposals') }}
        </a>
    @endcan
@endif

@can('index', mission())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.index') }}">
        @icon('handshake|mr:2|color:muted') {{ trans('foundation::menu_vendor.missions') }}
    </a>
@endcan

@can('index', [purchase_order(), auth()->user()->enterprise])
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('enterprise.purchase_order.index', Auth::user()->enterprise) }}">
        @icon('file-invoice|mr:2|color:muted') {{ trans('foundation::menu_vendor.purchase_ordres') }}
    </a>
@endcan

@can('index', mission_tracking())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.tracking.index') }}">
        @icon('chart-bar|mr:2|color:muted') {{ trans('foundation::menu_vendor.mission_trackings') }}
    </a>
@endcan

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_customer.others') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('infrastructure.export.index') }}">
    @icon('file-export|mr:2|color:muted') {{ trans('foundation::menu_support.exports') }}
</a>

