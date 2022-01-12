@inject('documentRepository', "App\Repositories\Addworking\Enterprise\DocumentRepository")
@inject('sectorRepository', 'Components\Mission\Offer\Application\Repositories\SectorRepository')

@if ($documentRepository->hasExpiredDocuments(Auth::user()->enterprise))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="mb-2">{{ __('addworking.user.dashboard._vendor.alert_expired_document') }}</div>
        <a href="{{ route('addworking.enterprise.document.index', Auth::user()->enterprise) }}" class="btn btn-warning btn-sm">
            {{ __('addworking.user.dashboard._vendor.alert_expired_document_button') }}
        </a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card-group pt-4">
    <a href="{{ route('profile.customers') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('users')</h5>
        <p class="card-text">{{ $count = count(Auth::user()->enterprise->customers) }}</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('addworking.user.dashboard._vendor.client', $count) }}</p>
    </a>

    <a href="{{ route('mission.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('suitcase')</h5>
        <p class="card-text">{{ $count = count(Auth::user()->enterprise->vendorMissions) }}</span></p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('messages.dashboard.missions', $count) }}</p>
    </a>

    <a href="{{ auth()->user()->enterprise->exists ? inbound_invoice([])->enterprise()->associate(auth()->user()->enterprise)->routes->index : '#' }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('file-invoice-dollar')</h5>
        <p class="card-text">{{ $count = count(Auth::user()->enterprise->inboundInvoices) }}</span></p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('messages.dashboard.invoices', $count) }}</p>
    </a>

    <a href="#" class="card dashboard-card col-md-3 py-4 text-center text-white bg-primary mb-3">
        <h5 class="card-title">@icon('inbox')</h5>
        <p class="card-text">0</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('messages.dashboard.messages', 0) }}</p>
    </a>
</div>

<div class="card-group">
    <a href="{{ route('contract.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('file-signature')</h5>
        <p class="card-text">{{ $data['contracts_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('addworking.user.dashboard._vendor.contract', $data['contracts_count']) }}</p>
    </a>
    <a href="{{ route('contract.index') }}?filter[states]=active" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('file-contract')</h5>
        <p class="card-text">{{ $data['active_contracts_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('addworking.user.dashboard._vendor.active_contract', $data['active_contracts_count']) }}</p>
    </a>
    @if ($sectorRepository->hasCustomerInConstructionSector(auth()->user()->enterprise))
        <a href="{{ route('sector.offer.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
    @else
        <a href="{{ route('mission.proposal.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
    @endif
        <h5 class="card-title">@icon('gift')</h5>
        <p class="card-text">{{ $data['proposals_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('addworking.user.dashboard._vendor.mission_proposal', $data['proposals_count']) }}</p>
    </a>
    <a href="{{ route('mission.index') }}" class="card dashboard-card col-md-3 py-4 text-center text-white bg-success mb-3">
        <h5 class="card-title">@icon('handshake')</h5>
        <p class="card-text">{{ $data['missions_of_this_month_count'] }}</p>
        <p class="card-text text-bold text-uppercase">{{ trans_choice('addworking.user.dashboard._vendor.missions_this_month', $data['missions_of_this_month_count']) }}</p>
    </a>
</div>

