@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.dashboard')."|href:".route('dashboard'))
        @if($contract)
            @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.contract', ['number' => $contract->getNumber()])."|href:".route('contract.show', $contract))
            @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.link_mission')."|active")
        @elseif($mission)
            @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.mission', ['number' => $mission->number])."|href:".route('mission.show', $mission))
            @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.link_contract')."|active")
        @endif
    @break

    @default
        @breadcrumb_item(__('components.contract.contract.application.views.contract_mission._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
