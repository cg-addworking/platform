@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.index')."|href:".route('support.annex.index', $annex))
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.create')."|active")
    @break

    @case('index')
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.index')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.index')."|href:".route('support.annex.index', $annex))
        @breadcrumb_item(__('components.contract.contract.application.views.annex._breadcrumb.show', ['number' => $annex->getNumber()])."|active")
    @break
@endswitch