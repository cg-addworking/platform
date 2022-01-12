@extends('foundation::layout.app.create', ['action' => route('contract_mission.store'), 'enctype' => "multipart/form-data"])

@section('title', $contract ?
    __('components.contract.contract.application.views.contract_mission.create.contract_title', ['number' => $contract->getNumber()]) :
    __('components.contract.contract.application.views.contract_mission.create.mission_title', ['number' => $mission->number])
)

@section('toolbar')
    @if($contract)
        @button(__('components.contract.contract.application.views.contract_mission.create.return')."|href:".route('contract.show', $contract)."|icon:arrow-left|color:secondary|outline|sm")
    @elseif($mission)
        @button(__('components.contract.contract.application.views.contract_mission.create.return')."|href:".route('mission.show', $mission)."|icon:arrow-left|color:secondary|outline|sm")
    @else
        @button(__('components.contract.contract.application.views.contract_mission.create.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm")
    @endif
@endsection

@section('breadcrumb')
    @include('contract::contract_mission._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @form_group([
        'text'         => __('components.contract.contract.application.views.contract_mission.create.contract'),
        'type'         => "select",
        'name'         => "contract_id",
        'options'      => $contracts,
        'selectpicker' => true,
        'search'       => true,
        'required'     => true,
        'value'        => optional($contract)->getId(),
        'disabled'     => $contract ? true : false,
    ])
    @if(!is_null($contract))
        <input type="hidden" name="contract_id" value="{{$contract->getId()}}">
        <input type="hidden" name="origin" value="contract">
    @endif

    @form_group([
        'text'         => __('components.contract.contract.application.views.contract_mission.create.mission'),
        'type'         => "select",
        'name'         => "mission_id",
        'options'      => $missions,
        'selectpicker' => true,
        'search'       => true,
        'required'     => true,
        'value'        => optional($mission)->getId(),
        'disabled'     => $mission ? true : false,
    ])
    @if(!is_null($mission))
        <input type="hidden" name="mission_id" value="{{$mission->id}}">
        <input type="hidden" name="origin" value="mission">
    @endif

    @button(__('components.contract.contract.application.views.contract_mission.create.submit')."|type:submit|color:success|shadow|icon:check")
@endsection
