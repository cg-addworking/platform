@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

@extends('foundation::layout.app.show')

@section('title', $mission->getLabel())

@section('toolbar')
    @can('linkMissionToContract', $mission)
        <div class="dropdown">
            <button class="btn btn-outline-success btn-sm dropdown-toggle mr-2" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @icon('plus') {{ __('mission::mission.show.contractualize') }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
                @if(auth()->user()->isSupport())
                    <a class="dropdown-item" href={{route('support.contract.create',['mission' =>$mission->getId()])}}> {{ __('mission::mission.show.create_contract') }}</a>
                @else
                    @can('create',get_class($contractRepository->make()))
                        <a class="dropdown-item" href={{route('contract.create',['mission' =>$mission->getId()])}}> {{ __('mission::mission.show.create_contract') }}</a>
                    @endcan
                @endif
                    <a class="dropdown-item" href={{route('contract.create_contract_without_model',['mission' =>$mission->getId()])}}> {{ __('mission::mission.show.submit_signed_contract') }}</a>
                    <a class="dropdown-item" href={{route('contract_mission.create',['mission' =>$mission->getId()])}}> {{ __('mission::mission.show.link_contract') }}</a>
            </div>
        </div>
    @endcan
    @button(__('mission::mission.show.return')."|href:#|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @include('mission::mission._actions_show')
@endsection

@section('breadcrumb')
    @include('mission::mission._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('mission::mission.construction._html')
@endsection
