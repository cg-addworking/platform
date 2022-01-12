<li class="nav-item">
    <a class="nav-link" href="{{ route('support.enterprise.omnisearch.index') }}">
        @icon('search|mr:2|color:muted') {{ __('layout.app._menu_support.omnisearch') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('support.enterprise.document.index') }}">
        @icon('archive|mr:2|color:muted') {{ __('layout.app._menu_support.documents') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('user.index') }}">
        @icon('users|mr:2|color:muted') {{ __('layout.app._menu_support.users') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('support.user.onboarding_process.index') }}">
        @icon('walking|mr:2|color:muted') {{ __('layout.app._menu_support.process_onboarding') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('enterprise.index') }}">
        @icon('building|mr:2|color:muted') {{ __('layout.app._menu_support.enterprise') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('sogetrel.passwork.index') }}">
        @icon('id-card|mr:2|color:muted') {{ __('layout.app._menu_support.passwork') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('file.index') }}">
        @icon('copy|mr:2|color:muted'){{ __('layout.app._menu_support.files') }}
    </a>
</li>

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    {{ __('layout.app._menu_support.call_for_tender') }}
</h6>

@can('index', referential())
    <li class="nav-item">
        <a class="nav-link" href="{{ config('app.subdomain') == 'everial' ? route('everial.mission.referential.index') : referential('')->routes->index}}">
            @icon('money-check-alt|mr:2|color:muted') {{ __('layout.app._menu_support.referential_missions') }}
        </a>
    </li>
@endcan

@can('index', mission_offer())
    <li class="nav-item">
        <a class="nav-link" href="{{ subdomain('everial') ? route('everial.mission-offer.index') : route(subdomain('edenred') ? 'edenred.mission-offer.index' : 'mission.offer.index') }}">
            @icon('bullhorn|mr:2|color:muted') {{ __('layout.app._menu_support.mission_offers') }}
        </a>
    </li>
@endcan

<li class="nav-item">
    <a class="nav-link" href="{{ route('mission.index') }}">
        @icon('handshake|mr:2|color:muted') {{ __('layout.app._menu_support.missions') }}
    </a>
</li>

@can('index', mission_proposal())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mission.proposal.index') }}">
            @icon('gift|mr:2|color:muted') {{ __('layout.app._menu_support.mission_proposal') }}
        </a>
    </li>
@endcan

@can('index', mission_tracking())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('support.enterprise.mission.tracking.line') }}">
            @icon('chart-bar|mr:2|color:muted') {{ __('layout.app._menu_support.tracking_lines') }}
        </a>
    </li>
@endcan

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    {{ __('layout.app._menu_support.invoices') }}
</h6>

<li class="nav-item" style="cursor: not-allowed">
    <a class="nav-link" href="{{ route('support.billing.inbound_invoice.index') }}">
        @icon('file-import|mr:2|color:muted') {{ __('layout.app._menu_support.service_provider_invoices') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('outbound_invoice.index') }}">
        @icon('file-export|mr:2|color:muted') {{ __('layout.app._menu_support.invoice_issued') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ vat_rate([])->routes->index }}">
        @icon('percent|mr:2|color:muted') {{ __('layout.app._menu_support.vat_rate') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ deadline_type([])->routes->index }}">
        @icon('clock|mr:2|color:muted') {{ __('layout.app._menu_support.payment_deadlines') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ legal_form([])->routes->index }}">
        @icon('clock|mr:2|color:muted') {{ __('layout.app._menu_support.legal_forms') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('support.enterprise.document_type.index') }}">
        @icon('file-alt|mr:2|color:muted') {{ __('layout.app._menu_support.types_of_documents') }}
    </a>
</li>

@can('index', edenred_code())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('edenred.common.code.index') }}">
            @icon('barcode|mr:2|color:muted') {{ __('layout.app._menu_support.trade_codes') }}
        </a>
    </li>
@endcan
