@inject('workFieldRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository')

<a class="list-group-item list-group-item-action bg-light " href="{{ route('dashboard') }}">
    @icon('home|mr:2') {{ trans('foundation::menu_customer.dashboard') }}
</a>

@can('viewAnyVendor', auth()->user()->enterprise)
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}">
        @icon('users|mr:2|color:muted') {{ trans('foundation::menu_customer.my_vendors') }}
    </a>
@endcan
@can('index', sogetrel_passwork())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('sogetrel.passwork.index') }}">
        @icon('id-card|mr:2|color:muted') {{ trans('foundation::menu_customer.passworks') }}
    </a>
@endcan

@can('index', edenred_code())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('edenred.common.code.index') }}">
        @icon('barcode|mr:2|color:muted') {{ trans('foundation::menu_customer.business_codes') }}
    </a>
@endcan

@if(auth()->user()->hasAccessToEnterprise())
    <h6 class="px-3 mt-3 mb-3 text-muted section-text">
        {{ trans('foundation::menu_customer.enterprise') }}
    </h6>
@endif

<a class="list-group-item list-group-item-action bg-light" href="{{ auth()->user()->enterprise->routes->show }}">
    @icon('building|mr:2|color:muted') {{ trans('foundation::menu_customer.my_enterprise') }}
</a>

@can('showInvitation', auth()->user()->enterprise)
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('addworking.enterprise.invitation.index', ['enterprise' => auth()->user()->enterprise]) }}">
        @icon('paper-plane|mr:2|color:muted') {{ trans('foundation::menu_customer.my_invitations') }}
    </a>
@endcan

@if(auth()->user()->hasAccessToContract())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('contract.index') }}">
        @icon('file-signature|mr:2|color:muted') {{ trans('foundation::menu_customer.my_contracts') }}
    </a>
@endif

@can('seeEntry', get_class($workFieldRepository->make()))
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('work_field.index') }}">
        @icon('building|mr:2|color:muted') {{ trans('foundation::menu_customer.my_work_fields') }}
    </a>
@endcan

@if(auth()->user()->hasAccessToMission())
    <h6 class="px-3 mt-3 mb-3 text-muted section-text">
        {{ trans('foundation::menu_customer.offers') }}
    </h6>
@endif

@if(subdomain('everial'))
    @can('index', referential())
        <a class="list-group-item list-group-item-action bg-light" href="{{ route('everial.mission.referential.index') }}">
            @icon('money-check-alt|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_referential') }}
        </a>
    @endcan
@endif

@if ($sectorRepository->belongsToConstructionSector(auth()->user()->enterprise))
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('sector.offer.index')}}">
        @icon('bullhorn|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_offers') }}
    </a>
@else
    @can('index', mission_offer())
        <a class="list-group-item list-group-item-action bg-light" href="{{ subdomain('everial') ? route('everial.mission-offer.index') : route(subdomain('edenred') ? 'edenred.mission-offer.index' : 'mission.offer.index') }}">
            @icon('bullhorn|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_offers') }}
        </a>
    @endcan

    @can('index', mission_proposal())
        <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.proposal.index') }}">
            @icon('gift|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_proposals') }}
        </a>
    @endcan
@endif

@can('index', mission())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.index') }}">
        @icon('handshake|mr:2|color:muted') {{ trans('foundation::menu_customer.missions') }}
    </a>
@endcan

@can('index', [purchase_order(), auth()->user()->enterprise])
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('enterprise.purchase_order.index', Auth::user()->enterprise) }}">
        @icon('file-invoice|mr:2|color:muted') {{ trans('foundation::menu_customer.purchase_ordres') }}
    </a>
@endcan

@can('index', mission_tracking())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.tracking.index') }}">
        @icon('chart-bar|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_trackings') }}
    </a>
@endcan

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_customer.invoices') }}
</h6>

@if (auth()->user()->hasAccessToBilling())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('addworking.billing.outbound.index', Auth::user()->enterprise) }}">
        @icon('file-invoice-dollar|mr:2|color:muted') {{ trans('foundation::menu_customer.outbound_invoices') }}
    </a>
@endif
@can('indexCustomer', inbound_invoice())
<a class="list-group-item list-group-item-action bg-light" href="{{ route('inbound_invoice.index_customer', ) }}">
    @icon('file-import|mr:2|color:muted') {{ trans('foundation::menu_customer.inbound_invoices') }}
</a>
@endcan

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_customer.others') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('infrastructure.export.index') }}">
    @icon('file-export|mr:2|color:muted') {{ trans('foundation::menu_support.exports') }}
</a>
