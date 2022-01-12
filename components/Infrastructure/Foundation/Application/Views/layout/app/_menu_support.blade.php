<a class="list-group-item list-group-item-action bg-light " href="{{ route('dashboard') }}">
    @icon('home|mr:2') {{ trans('foundation::menu_customer.dashboard') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.enterprise.omnisearch.index') }}">
    @icon('search|mr:2|color:muted') {{ trans('foundation::menu_support.omnisearch') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.enterprise.document.index') }}">
    @icon('archive|mr:2|color:muted') {{ trans('foundation::menu_support.documents') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('user.index') }}">
    @icon('users|mr:2|color:muted') {{ trans('foundation::menu_support.users') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.user.onboarding_process.index') }}">
    @icon('walking|mr:2|color:muted') {{ trans('foundation::menu_support.onboarding_processes') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.contract.index') }}">
    @icon('file-signature|mr:2|color:muted') {{ trans('foundation::menu_support.contracts') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.enterprise.index') }}">
    @icon('building|mr:2|color:muted') {{ trans('foundation::menu_support.enterprises') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('sogetrel.passwork.index') }}">
    @icon('id-card|mr:2|color:muted') {{ trans('foundation::menu_support.passworks') }}
</a>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('file.index') }}">
    @icon('copy|mr:2|color:muted') {{ trans('foundation::menu_support.files') }}
</a>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('infrastructure.export.index') }}">
    @icon('file-export|mr:2|color:muted') {{ trans('foundation::menu_support.exports') }}
</a>

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_support.offers') }}
</h6>

@can('index', referential())
    <a class="list-group-item list-group-item-action bg-light" href="{{ config('app.subdomain') == 'everial' ? route('everial.mission.referential.index') : referential('')->routes->index}}">
        @icon('money-check-alt|mr:2|color:muted') {{ trans('foundation::menu_support.mission_referential') }}
    </a>
@endcan

@can('index', mission_offer())
    <a class="list-group-item list-group-item-action bg-light" href="{{ subdomain('everial') ? route('everial.mission-offer.index') : route(subdomain('edenred') ? 'edenred.mission-offer.index' : 'mission.offer.index') }}">
        @icon('bullhorn|mr:2|color:muted') {{ trans('foundation::menu_support.mission_offers') }}
    </a>
@endcan

<a class="list-group-item list-group-item-action bg-light" href="{{ route('sector.offer.index')}}">
    @icon('bullhorn|mr:2|color:muted') {{ trans('foundation::menu_support.mission_offers_construction') }}
</a>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.index') }}">
    @icon('handshake|mr:2|color:muted') {{ trans('foundation::menu_support.missions') }}
</a>

@can('index', mission_proposal())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('mission.proposal.index') }}">
        @icon('gift|mr:2|color:muted') {{ trans('foundation::menu_support.mission_proposals') }}
    </a>
@endcan

@can('index', mission_tracking())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('support.enterprise.mission.tracking.line') }}">
        @icon('chart-bar|mr:2|color:muted') {{ trans('foundation::menu_support.mission_tracking_lines') }}
    </a>
@endcan

<a class="list-group-item list-group-item-action bg-light" href="{{ route('sogetrel.mission.mission_tracking_line_attachment.index') }}">
    @icon('chart-bar|mr:2|color:muted') {{ trans('foundation::menu_support.sogetrel_mission_tracking_line_attachments') }}
</a>

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_support.invoices') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.billing.inbound_invoice.index') }}">
    @icon('file-import|mr:2|color:muted') {{ trans('foundation::menu_support.inbound_invoices') }}
</a>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.billing.outbound.index') }}">
    @icon('exclamation-circle|mr:2|color:muted') {{ trans('foundation::menu_support.outbound_invoices') }}
</a>

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_support.payments') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.received_payment.index') }}">
    @icon('check|mr:2|color:muted') {{ trans('foundation::menu_support.received_payments') }}
</a>

<h6 class="px-3 mt-3 mb-3 text-muted section-text">
    {{ trans('foundation::menu_support.parameters') }}
</h6>

<a class="list-group-item list-group-item-action bg-light" href="{{ vat_rate([])->routes->index }}">
    @icon('percent|mr:2|color:muted') {{ trans('foundation::menu_support.tva_rates') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ deadline_type([])->routes->index }}">
    @icon('clock|mr:2|color:muted') {{ trans('foundation::menu_support.deadlines') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ legal_form([])->routes->index }}">
    @icon('clock|mr:2|color:muted') {{ trans('foundation::menu_support.legal_forms') }}
</a>
<a class="list-group-item list-group-item-action bg-light" href="{{ route('support.enterprise.document_type.index') }}">
    @icon('file-alt|mr:2|color:muted') {{ trans('foundation::menu_support.document_types') }}
</a>

@can('index', edenred_code())
    <a class="list-group-item list-group-item-action bg-light" href="{{ route('edenred.common.code.index') }}">
        @icon('barcode|mr:2|color:muted') {{ trans('foundation::menu_support.business_codes') }}
    </a>
@endcan
