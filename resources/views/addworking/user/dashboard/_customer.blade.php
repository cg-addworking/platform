@inject('sectorRepository', 'Components\Mission\Offer\Application\Repositories\SectorRepository')

<div class="card-group pt-4">
    <a href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('users')</h5>
        <p class="card-text">{{ $data['vendors_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.providers') }}</p>
    </a>
    <a href="{{ route('mission.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('suitcase')</h5>
        <p class="card-text">{{ $data['missions_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.mission') }}</p>
    </a>
    <a href="{{ route('addworking.billing.outbound.index', auth()->user()->enterprise) }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('file-invoice-dollar')</h5>
        <p class="card-text">{{ $data['customer_invoices_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.invoices') }}</p>
    </a>
    @if ($sectorRepository->belongsToConstructionSector(auth()->user()->enterprise))
        <a href="{{ route('sector.offer.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
            @else
                <a href="{{ route('mission.offer.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
                    @endif
                    <h5 class="card-title">@icon('inbox')</h5>
                    <p class="card-text">{{ $data['unread_responses_count'] }}</p>
                    <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.new_response') }}</p>
                </a>
</div>

<div class="card-group">
    <a href="{{ route('contract.index')}}?filter[enterprises][]={{auth()->user()->enterprise->id}}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('file-signature')</h5>
        <p class="card-text">{{ $data['contracts_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.contract') }}</p>
    </a>
    <a href="{{ route('contract.index') }}?filter[enterprises][]={{auth()->user()->enterprise->id}}&filter[states]=active" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('file-contract')</h5>
        <p class="card-text">{{ $data['active_contracts_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.active_contract') }}</p>
    </a>
    <a href="{{ route('mission.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('handshake')</h5>
        <p class="card-text">{{ $data['missions_of_this_month_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.missions_this_month') }}</p>
    </a>
    @if ($sectorRepository->belongsToConstructionSector(auth()->user()->enterprise))
        <a href="{{ route('sector.offer.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
            @else
                <a href="{{ config('app.subdomain') == 'everial' ? route('everial.mission-offer.index') : route('mission.offer.index')}}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
                    @endif
                    <h5 class="card-title">@icon('tasks')</h5>
                    <p class="card-text">{{ $data['offers_to_validate_count'] }}</p>
                    <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.validate_offer') }}</p>
                </a>
</div>

<div class="card-group">
    <a href="" class="card dashboard-card col-md-3 py-4 text-center text-white bg-danger mb-3">
        <h5 class="card-title">@icon('chart-bar')</h5>
        <p class="card-text">&nbsp;</p>
        <p class="card-text text-bold text-uppercase">{{ __('addworking.user.dashboard._customer.performance') }}</p>
    </a>
    <a href="" class="card dashboard-card col-md-3 py-4 text-center text-white bg-danger mb-3">
        <h5 class="card-title">@icon('ellipsis-h')</h5>
        <p class="card-text">&nbsp;</p>
        <p class="card-text text-bold text-uppercase">&nbsp;</p>
    </a>
</div>
