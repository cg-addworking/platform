@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.dashboard')."|href:".route('dashboard'))
        @if(auth()->user()->isSupport())
            @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.index')."|href:".route('support.contract.index'))
        @else
            @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.index')."|href:".route('contract.index'))
        @endif
        @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.show', ['number' => $contract->getNumber()])."|href:".route('contract.show', $contract))
        @breadcrumb_item(__('components.contract.contract.application.views.contract._breadcrumb.create_part')."|active")
    @break
@endswitch