@inject('sectorRepository', 'Components\Mission\Offer\Application\Repositories\SectorRepository')

<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
@if ($sectorRepository->belongsToConstructionSector(auth()->user()->enterprise))
    <a class="dropdown-item text-primary" href="{{ route('sector.mission.show', $mission) }}">
        <i class="text-primary mr-3 fa fa-eye"></i> {{ __('addworking.mission.mission._actions.consult') }}
    </a>
    <a class="dropdown-item text-warning" href="{{ route('sector.mission.edit', $mission) }}">
        <i class="text-warning mr-3 fa fa-edit"></i> {{ __('addworking.mission.mission._actions.edit') }}
    </a>
@else
    @can('show', $mission)
        <a class="dropdown-item text-primary" href="{{ route('mission.show', $mission) }}">
            <i class="text-primary mr-3 fa fa-eye"></i> {{ __('addworking.mission.mission._actions.consult') }}
        </a>
    @endcan

    @can('update', $mission)
        <a class="dropdown-item text-warning" href="{{ route('mission.edit', $mission) }}">
            <i class="text-warning mr-3 fa fa-edit"></i> {{ __('addworking.mission.mission._actions.edit') }}
        </a>
    @endcan
@endif

@can('close', $mission)
    <a class="dropdown-item text-success" href="{{ route('mission.close', $mission) }}">
        <i class="text-success mr-3 fa fa-check-square"></i> {{ __('addworking.mission.mission._actions.complete_mission') }}
    </a>
@endcan

@if($mission->hasMilestoneType())
    @can('index', mission_tracking())
        <a class="dropdown-item" href="{{ route('mission.tracking.index') }}?filter[mission]={{ $mission->label }}">
            <i class="mr-3 fas fa-plus-square"></i></i> {{ __('addworking.mission.mission._actions.mission_monitoring') }}
        </a>
    @endcan

    @can('create', mission_tracking())
        <a class="dropdown-item" href="{{ route('mission.tracking.create', $mission) }}">
            <i class="mr-3 fas fa-plus-square"></i></i> {{ __('addworking.mission.mission._actions.mission_followup') }}
        </a>
    @endcan
@else
    @can('update', $mission)
        <a class="dropdown-item" href="{{ route('mission.create_milestone_type', $mission) }}">
            <i class="mr-3 fas fa-plus-square"></i></i> {{ __('addworking.mission.mission._actions.define_tracking_mode') }}
        </a>
    @endcan
@endif

@php
    $spf   = enterprise('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES');
@endphp

@if($mission->customer->is($spf) || $spf->descendants()->contains($mission->customer))
    @if($mission->purchaseOrder()->exists())
        <a class="dropdown-item text-primary" href="{{ $mission->purchaseOrder->routes->show }}">
            @icon('eye|mr:2|color:primary') {{ __('addworking.mission.mission._actions.order_form') }}
        </a>
        @can('delete', $mission->purchaseOrder)
            <a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.mission.mission._actions.confirm_deletion') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('trash|mr:2|color:danger')<span class="text-danger">{{ __('addworking.mission.mission._actions.delete_purchase_order') }}</span>
            </a>
            @push('modals')
                <form name="{{ $name }}" action="{{ $mission->purchaseOrder->routes->destroy }}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            @endpush
        @endcan
    @else
        @can('create', [purchase_order(), $mission])
            <a class="dropdown-item text-primary" href="#" onclick='confirm("{{ __('addworking.mission.mission._actions.confirm_generate_purchase_order') }}") && document.forms["{{ $name = uniqid("form_") }}"].submit()'>
                @icon('file-invoice|mr:2|color:primary')<span>{{ __('addworking.mission.mission._actions.generate_order_form') }}</span>
            </a>
            @push('modals')
                <form name="{{ $name }}" action="{{ route('enterprise.mission.purchase_order.store', [$mission->customer, $mission]) }}" method="POST">
                    @csrf
                </form>
            @endpush
        @endcan
    @endif
@endif

@can('destroy', $mission)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('addworking.mission.mission._actions.remove') }} </span>
    </a>

    @push('forms')
        <form name="{{ $name }}" action="{{ route('mission.destroy', $mission) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endcan

@push('modals')

@component('components.form.modal', [
    'id' => "change-status-{$mission->id}",
    'action' => route('mission.update', $mission),
    'method' => 'put'
    ])
    @slot('title')
        Changer le statut
    @endslot

    @component('components.form.group', [
        'type'   => "select",
        'name'   => "mission.status",
        'values' => array_trans(array_mirror(mission()::getAvailableStatuses()),'mission.mission.status_'),
        'value'  => $mission->status,
    ])
        @slot('label')
            @lang('mission.mission.status')
        @endslot
    @endcomponent
@endcomponent

@endpush

    </div>
</div>
