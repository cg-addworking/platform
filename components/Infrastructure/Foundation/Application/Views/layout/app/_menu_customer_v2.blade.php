@inject('workFieldRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository')

<a class="list-group-item list-group-item-action mb-2" href="{{ route('dashboard') }}">
    @icon('home|mr:2') {{ trans('foundation::menu_customer.dashboard') }}
</a>

<a class="list-group-item list-group-item-action mb-2" href="{{ auth()->user()->enterprise->routes->show }}">
    @icon('building|mr:2|color:muted') {{ trans('foundation::menu_customer.my_enterprise') }}
</a>

@can('viewAnyVendor', auth()->user()->enterprise)
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}">
        @icon('users|mr:2|color:muted') {{ trans('foundation::menu_customer.my_vendors') }}
    </a>
@endcan

@can('seeEntry', get_class($workFieldRepository->make()))
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('work_field.index') }}">
        @icon('building|mr:2|color:muted') {{ trans('foundation::menu_customer.my_work_fields') }}
    </a>
@endcan

<a class="list-group-item list-group-item-action mb-2" href="{{ route('sector.offer.index')}}">
    @icon('bullhorn|mr:2|color:muted') {{ trans('foundation::menu_customer.mission_offers') }}
</a>

@can('index', mission())
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('mission.index') }}">
        @icon('handshake|mr:2|color:muted') {{ trans('foundation::menu_customer.missions') }}
    </a>
@endcan

@if(auth()->user()->hasAccessToContract())
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('contract.index') }}">
        @icon('file-signature|mr:2|color:muted') {{ trans('foundation::menu_customer.my_contracts') }}
    </a>
@endif

@if (auth()->user()->hasAccessToBilling())
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('addworking.billing.outbound.index', Auth::user()->enterprise) }}">
        @icon('file-invoice-dollar|mr:2|color:muted') {{ trans('foundation::menu_customer.outbound_invoices') }}
    </a>
@endif

@can('indexCustomer', inbound_invoice())
    <a class="list-group-item list-group-item-action mb-2" href="{{ route('inbound_invoice.index_customer', ) }}">
        @icon('file-import|mr:2|color:muted') {{ trans('foundation::menu_customer.inbound_invoices') }}
    </a>
@endcan
